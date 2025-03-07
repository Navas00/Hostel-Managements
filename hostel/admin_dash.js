
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        var url=window.location.search.substring(1);
        success="<div class=\"alert alert-success alert-dismissible fade show\"> \
                 <h4 class=\"text-center\">Data Is Updated!</h4> \
                 <h6 class=\"text-center\">Thank You!</h6> \
                 </div>";
        if(url == "update=1"){
            $(".col-md-3").attr("style","display:none");
            $("table").attr("style","display:none");
            $("h3").attr("style","display:none");
            $(".inbox").html(success);
            setTimeout(manageroom,2000);

        }

        if(url == "addstaff=true"){
            $(".col-md-3").attr("style","display:none");
            $("table").attr("style","display:none");
            $("h3").attr("style","display:none");
            $(".inbox").html(success);
            setTimeout(rstaff,2500);

        }

        function mgstaff(){
            if(url == "ds=true"){
            $(".col-md-3").attr("style","display:none");
            $("table").attr("style","display:none");
            $("h3").attr("style","display:none");
            $(".inbox").html(success);
            setTimeout(managestaff,2500);

        }
        }

        function getnotification(){
            $.get("check-vacate.php",function(data,status){
                 $("#nnum").html(data);
            })
        }

        getnotification();

        function logout(){
            $.post("db.php",{
                logout: "true"
            },function(data,status){
                window.location="http://127.0.0.1/login/glass_login.php";
            })
        }


        function showroom(){
            if($("#sub-room").hasClass("d-none")){
                $("#sub-room").removeClass("d-none");
                $("#arrow").removeClass("fa-angle-right");
                $("#arrow").addClass("fa-angle-down");
            } else{
                $("#sub-room").addClass("d-none");
                $("#arrow").addClass("fa-angle-right");
                $("#arrow").removeClass("fa-angle-down");
            }
        }

        function showstaff(){
            if($(".sub-staff").hasClass("d-none")){
                $(".sub-staff").removeClass("d-none");
                $("#sarrow").removeClass("fa-angle-right");
                $("#sarrow").addClass("fa-angle-down");
            } else{
                $(".sub-staff").addClass("d-none");
                $("#sarrow").addClass("fa-angle-right");
                $("#sarrow").removeClass("fa-angle-down");
            }
        }

        function managestaff(){
            $.post("db.php",{
                mgstaff : true
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function deletestaff(phone){
            $.post("db.php",{
                deletestaff : true,
                phoneno : phone
            },function(data,status){
                mgstaff();
            })
        }

        function showmsg(){
            var html;
            $.get("check-vacate.php?data=1",function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function showdetail(tok){
            $.post("check-vacate.php",{
                view : "true",
                token : tok
            },function(data,status){
                $("ul").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function editerow(room_id){
            $.post("db.php",{
                roomd : "true",
                room_no : room_id
            },function(data,status){
                $(".inbox").html(data);
            })
        }

        function accept(){
            toke=$("#token").val();
            rl=$("#rollnum").val();
            $.post("check-vacate.php",{
                status : "accept",
                tok : toke
            },function(data,status){
                $("#"+rl).attr("style","display:none");
                $(".inbox").html(data);
                getnotification();

            });
        }

        function reject(){
            toke=$("#token").val();
            rl=$("#rollnum").val();
            $.post("check-vacate.php",{
                status : "reject",
                tok : toke
            },function(data,status){
                $("#"+rl).attr("style","display:none");
                $(".inbox").html(data);
                getnotification();
            });
        }

        function deleterow(room){
            $.post("db.php",{
                deletetable : "true",
                room_id : room
            },function(data,status){
                manageroom();
            })
        }

        function dstudent(roll){
            $.post("db.php",{
                dstudent : "true",
                roll_no : roll
            },function(data,status){
                get_student();
            })
        }

        function manageroom(){
            $.post("db.php",{
                getroom : "true"
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function rstaff(){
            $.post("db.php",{
                regstaff : "true"
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function get_student(){
            $.post("db.php",{
                getstudent : "true"
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }