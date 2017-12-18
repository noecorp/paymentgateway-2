'use strict'

var server_url = "http://192.168.43.80:1334/api";

$("#checkoutform_user_details").on("submit",(e)=>{
       e.preventDefault();
       var data = {};
           data.phonenumber = $("#phone").val();
           data.sid=$(".phonelabel").data('sid');
       $.ajax({
                type: 'POST',
                url: server_url + '/checkoutform_user_details',
                data: JSON.stringify(data),
                success: function(data) {
                    console.log(data);
                    window.location.href = data.url;
                },
                contentType: "application/json",
                dataType: 'json'
                });
});

$("#checkoutform_verifyOTP").on("submit",(e)=>{
       e.preventDefault();
       var data = {};
           data.otp = $("#otp").val();
           data.cid=$(".otplabel").data('cid');
           data.phonenumber=$(".otplabel").data('phone');
           console.log("OTP verified");
       $.ajax({
                type: 'POST',
                url: server_url + '/checkoutform_verifyOTP',
                data:JSON.stringify(data),
                success: function(data) {
                    console.log(data);
                    window.location.href = data.url;
                },
                contentType: "application/json",
                dataType: 'json'
                });
});

$("#checkoutform_password").on("submit",(e)=>{
       e.preventDefault();
       var data = {};
           data.otp = $("#password").val();
       $.ajax({
                type: 'POST',
                url: server_url + '/checkoutform_password',
                data: JSON.stringify(data),
                success: function(data) {
                    console.log(data);
                    window.location.href = data.url;
                },
                contentType: "application/json",
                dataType: 'json'
                });
});







