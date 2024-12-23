/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($) {
    $.fn.update = function (options) {
        console.log(this);
        var formObj = '';
        var formUrl = '';
        console.log(this.is('form'));
        console.log(this.is('a'));
        if (this.is('form')) {
//            formObj = this.find("form");
            formObj = this.closest('form');
            formUrl = formObj.attr('action');
            var str = formObj.serialize();
        } else if (this.is('a')) {


            formObj = this;

//         console.log(this.currentTarget)
//            formObj = this.target;
//
//         console.log(this.currentTarget)


            formUrl = formObj.attr('href');
//            temp=formUrl.split('#').
//            formUrl=temp[1];
        }


//                 console.log(this);
        var settings = $.extend({
            // These are the defaults.
            destination: this.selector,
            url: formUrl,
//                    dataType : "json",
            type: "POST",
            cache: false,
            data: str,
            loadView: true,
            success: function (response) {




                if ($.type(response) == 'object')
                {

                    //It is JSON
                    console.log(response)
                    console.log("It is  a json type");
                } else {

                    if (settings.loadView) {
                        $(settings.destination).html(response);
                    }

                    // is not a JSON type
                    // console.log(response)
                    console.log("It is not a json type");
                }

            },
            // Code to run if the request fails; the raw request and
//                    // status codes are passed to the function
            error: function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            },
            complete: function (xhr, status) {
               // alert("The request is complete!");
            }
        }, options);
        $.ajax(settings)



//                alert(formUrl);

//                console.log(str);
//                console.log(settings);



//                return this;
    }
}(jQuery));
