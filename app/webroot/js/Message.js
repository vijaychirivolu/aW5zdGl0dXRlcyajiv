/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getStatus() {
    var SITEURL = window.location.origin;
    $.ajax({
        url : SITEURL+"/messages/getRecentMessages",
        type : "post",
        dataType : "json",
        success : function(response) {
            var message = "";
            for (var i = 0; i <response.length; i++) {
                var message = message + "<li><div class='dropdown-messages-box'><a href='#' class='pull-left'><img src = '../img/profile.jpg' alt='image' class='img-circle'></a>";
                var message = message + "<div class='media-body'>";
                var message = message + "<small class='pull-right'></small>";
                var message = message + "<strong>Monica Smith</strong> love <strong>Kim Smith</strong>.<br>";
                var message = message + "<small class='text-muted'>"+response[i]['MessageReceiver']['time_created']+"</small>";
                var message = message + "</div></div></li>";
            }
            var message = message + "<li class='divider'></li>";
            var message = message + "<li><div class='text-center link-block'><a href='"+SITEURL+"/messages/index'>";
            var message = message + "<i class='fa fa-envelope'></i> <strong>Read All Messages</strong>";
            var message = message + "</a></div></li>";
            $(".dropdown-messages").html(message);
        }
    });
    setTimeout("getStatus()",10000);
}

/**
* 
* @returns {undefined}
*/

function messagePerminentDelete() {
   $(".perminent-delete").click(function () {
       var favorite = [];
       $.each($("input[class='check-message']:checked"), function () {
           favorite.push($(this).val());
       });
       var trshmsgids = favorite.join(",");
       if (trshmsgids.length != 0) {
           $.ajax({
               url: SITEURL + "messages/messagePerminentDelete",
               type: 'POST',
               data: "trshids=" + trshmsgids,
               dataType: "json",
               success: function (data, textStatus, jqXHR)
               {
                   swal("Perminent Delete Alert!", data.msg);
                   var dataTable = $('.trashmessages-table').DataTable();
                   dataTable.draw();
               },
               error: function (jqXHR, textStatus, errorThrown)
               {
                   ajaxFlag = false;
               }
           });
       } else {
           swal("Delete Alert!", "Please select messages to delete.");
           return false;
       }
   });
}
    
    