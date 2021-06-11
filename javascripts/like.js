$(function(){
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
            data: { messageId: goodPostId, isActive: isActive }
        }).done(function(data){
            console.log('Ajax Success');

            // いいねの総数を表示
            $this.children('span').html();
            // いいね取り消しのスタイル
            $this.children('i').toggleClass('far'); //空洞ハート
            // いいね押した時のスタイル
            $this.children('i').toggleClass('fas'); //塗りつぶしハート
            $this.children('i').toggleClass('active');
            $this.toggleClass('active');
        }).fail(function(msg) {
            console.log('Ajax Error');
        });
    });
});