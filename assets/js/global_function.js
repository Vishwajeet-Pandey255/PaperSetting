 function delete_data(url) {
     Lobibox.confirm({
         msg: "Are you sure you want to delete it?",
         callback: function($this, type) {
             if (type === 'yes') {
                 window.location = url;
             }
             //  } else if (type === 'no') {
             //      Lobibox.notify('info', {
             //          msg: 'You have clicked "No" button.'
             //      });
             //  }
         }
     });

 }


 function edit_data(url) {

     Lobibox.confirm({
         msg: "Are you sure you want to edit it?",
         callback: function($this, type) {
             if (type === 'yes') {
                 window.location = url;
             }
         }
     });


 }
 
  function approve_data(url) {

     Lobibox.confirm({
         msg: "Are you sure you want to send this paper for approval?",
         callback: function($this, type) {
             if (type === 'yes') {
                 window.location = url;
             }
         }
     });


 }
 
 function View_Paper(url) {

     Lobibox.confirm({
         msg: "Are you sure you want to create paper final preview?",
         callback: function($this, type) {
             if (type === 'yes') {
                 window.location = url;
             }
         }
     });


 }
 





 function ApprovedPaper(url) {
     Lobibox.confirm({
         msg: "Are you sure you want to Update it?",
         callback: function($this, type) {
             if (type === 'yes') {
                 window.location = url;
             }
             //  } else if (type === 'no') {
             //      Lobibox.notify('info', {
             //          msg: 'You have clicked "No" button.'
             //      });
             //  }
         }
     });

 }




 function submenu_data(url) {

     Lobibox.confirm({
         msg: "Are you sure you want to open submenu ?",
         callback: function($this, type) {
             if (type === 'yes') {
                 window.location = url;
             }
         }
     });


 }


 function view_invoice(url) {

     //window.location = url;
     window.open(url);

 }

 function update_password() {

     var opass = $("#opass").val();
     var npass = $("#npass").val();
     var cpass = $("#cpass").val();
     //alert("hiii");
     if (opass == '') {
         Lobibox.notify("error", { msg: "please enter old password" });
     } else if (npass == '') {
         Lobibox.notify("error", { msg: "please enter new password" });
     } else if (cpass == '') {
         Lobibox.notify("error", { msg: "please enter confirm password" });
     } else if (npass != cpass) {
         Lobibox.notify("error", { msg: " your new password and confirm password are different please enter same password, " });
     } else {
         //$("#update_password").submit();
         $.ajax({
             url: SITE_URL + "user/update_password",
             type: "get",
             data: { opass: opass, npass: npass, cpass: cpass },
             cache: false,
             dataType: "json",
             success: function(datas) {
                 console.log();
                 if (datas.status == 'error') {
                     Lobibox.notify(datas.status, { msg: datas.msg });
                 } else {
                     $("#opass").val('');
                     $("#npass").val('');
                     $("#cpass").val('');
                     Lobibox.notify(datas.status, { msg: datas.msg });
                 }


             }
         });


     }




 }

 function check_password(pass) {
     $.ajax({
         url: SITE_URL + "user/check_password",
         type: "get",
         data: { pass: pass },
         cache: false,
         dataType: "json",
         success: function(datas) {
             console.log();
             Lobibox.notify(datas.status, { msg: datas.msg });
             window.location = SITE_URL + "Admin/register_user";

         }
     });
 }


 function approve_user(id = '', user_status = '') {
     if (confirm("Are you sure you want to update user status ?")) {
         //window.location = url;
         //alert(user_status);
         $.ajax({
             url: SITE_URL + "admin/approve_user",
             type: "get",
             data: { id: id, user_status: user_status },
             cache: false,
             dataType: "json",
             success: function(datas) {
                 console.log();
                 Lobibox.notify(datas.status, { msg: datas.msg });
                 window.location = SITE_URL + "Admin/register_user";

             }
         });
     }
 }


 function hide_underof(valu) {
     if (valu == 1) {
         $('#section_underof').hide('slow');
         $("#under").val('0');
     } else if (valu == 2) {
         $('#section_underof').show('slow');
     } else {
         alert("please select Page type");
         $('#section_underof').hide('slow');
         $("#under").val('0');
     }
 }


 function delete_product_image(id, img_name, img_no) {
     //alert('<?= PATH_ADMIN ?>');
     if (confirm("Are You Saure You Want To Delete This Image!")) {
         $.getJSON(SITE_URL + "admin/delete_product_image", { id: id, img_name: img_name }, function(data) {

             if (data.status == 'success') {
                 Lobibox.notify(data.status, { msg: data.msg });
                 $('#other_imag_' + img_no).hide();
             }
         });
         //return false;
     } else {
         txt = "You pressed Cancel!";
     }

 }

 function getvolume_data(id) {
     //alert(id);
     $.getJSON(SITE_URL + "admin/getvolume_data", { id: id }, function(data) {
         console.log(data);
         var datas = '<option value=" ">Select Volume name</option>';
         if (data.status == 'success') {
             $.each(data.datas, function(key, val) {
                 if (val.status == 1) {
                     datas += '<option value="' + val.id + '">' + val.name + '</option>';
                 }
             })

         } else {
             datas = '<option value=" ">Select Volume name</option>';
         }
         $(".getvolume_data").html(datas);
     });
 }

 function getishue_data(volume, category) {
     //alert(volume+"//"+category);
     $.getJSON(SITE_URL + "admin/getishue_data", { volume: volume, category: category }, function(data) {
         console.log(data);
         var datas = '<option value=" ">Select Ishue name</option>';
         if (data.status == 'success') {
             $.each(data.datas, function(key, val) {
                 datas += '<option value="' + val.id + '">' + val.name + '</option>';
             })

         } else {
             datas = '<option value=" ">Select Ishue name</option>';
         }
         $(".getishue_data").html(datas);
     });
 }


 function check_validation() {
     var name = $("#name").val();
     var year = $("#year").val();
     var category = $("#category").val();

     var action = $("#action").val();

     //alert(action)
     if (name == '') {
         Lobibox.notify('error', { msg: 'Please Enter  Name' });
         $("#name").focus();
     } else if (year == '') {
         Lobibox.notify('error', { msg: 'Please Enter year' });
         $("#year").focus();
     } else if (category == '') {
         Lobibox.notify('error', { msg: 'Please Enter category' });
         $("#category").focus();
     }


     //            }else if(content==''){
     //                Lobibox.notify('error', { msg: 'Please Enter  Content' });
     //                $("#content").focus();
     //            }
     else {
         $('#session_form').submit();
     }


 }



 $(function() {
     $("#example1").DataTable({
         "responsive": true,
         "autoWidth": true,
         "ordering": true,
         "paging": true,
         "lengthChange": true,
         "searching": true,
         "ordering": true,
         "info": true,
         "autoWidth": true,
         "responsive": true,
     });
     $('#example2').DataTable({
         "responsive": true,
         "autoWidth": true,
         "paging": true,
         "lengthChange": false,
         "searching": false,
         "ordering": false,
         "info": true,
         "autoWidth": true,
         "responsive": true,
     });
     $('#example3').DataTable({
         // "responsive": true,
         //"autoWidth": true,
         //  "ordering": true,
         "paging": true,
         "lengthChange": true,
         "searching": true,
         "ordering": false,
         // "info": true,
         //  "autoWidth": true,
         "responsive": true,
     });
 });


 function print_div() {
     // alert('hiiii');
     var divToPrint = document.getElementById("printdata");
     newWin = window.open("");
     newWin.document.write(divToPrint.outerHTML);
     newWin.print();
     newWin.close();
 }
