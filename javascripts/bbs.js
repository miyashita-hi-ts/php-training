$(function(){

 $('#ajax').on('click',function(){

  $.ajax({
   url:'./bbs_api.php', //送信先
   type:'POST', //送信方法
   datatype: 'json', //受け取りデータの種類
   data:{
    'view_name' : $('#view_name').val(),
    'message' : $('#message').val()
   }
   })
   // Ajax通信が成功した時
   .done( function(data) {
   console.log('通信成功');
   var html = "";
   var view_name = data.view_name;
   var message = data.message;
   var current_date = data.current_date;
   html += "<article><div class='info'><h2>" + view_name + "</h2> <time>"+ current_date + "</time></div><p>" + message + "</p></article>";
   $("#logList").prepend(html);
   })
   // Ajax通信が失敗した時
   .fail( function(data) {
   $('#result').html(data);
   console.log('通信失敗');
   })
 }); //#ajax click end

}); //END
