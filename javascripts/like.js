$(function(){
    if (!Cookies.get('like_active_messages')) {
        Cookies.set('like_active_messages', []);
    }
    var active_messages = Cookies.get('like_active_messages');
    console.log(active_messages.push(1));
    var $good = $('.btn-like'), //いいねボタンセレクタ
                goodPostId, //投稿ID
                isActive;
    $good.on('click',function(e){
        e.stopPropagation();
        var $this = $(this);
        //カスタム属性（message_id）に格納された投稿ID取得
        goodPostId = $this.parents('.post').data('message_id');
        isActive = $this.children('i.active').length == 0;
        $.ajax({
            type: 'POST',
            url: 'like_button.php', //post送信を受けとるphpファイル
            datatype: 'json', //受け取りデータの種類
            data: { messageId: goodPostId, isActive: isActive }
        }).done(function(data){
            console.log(data);

            // いいねの総数を表示
            const log = console.log;
            console.log = function(...args){
                log(...args);
                $this.children('span').html(args[0].split('"')[1]);
            }

            // いいね取り消しのスタイル
            $this.children('i').toggleClass('far'); //空洞ハート
            // いいね押した時のスタイル
            $this.children('i').toggleClass('fas'); //塗りつぶしハート
            $this.children('i').toggleClass('active');
            $this.toggleClass('active');

            if (isActive) {
                active_messages.push(goodPostId);
                Cookies.set('like_active_messages', active_messages);
            } else {
                for (i = 0; i < active_messages.length; i++) {
                    if (active_messages[i] == goodPostId) {
                        active_messages.splice(i, 1);
                    }
                }
                Cookies.set('like_active_messages', active_messages);
            }
            console.log(Cookies.get('like_active_messages'));
        }).fail(function(msg) {
            console.log('Ajax Error');
        });
    });
});

console.log(Cookies.get('like_active_messages'));