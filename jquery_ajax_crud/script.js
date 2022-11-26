$(function(){
    function load_table(page,term=""){
        $.ajax({
            url: "data_process.php",
            type: "POST",
            data: {target:"load",page:page,term:term},
            success: function(data){
                console.log(data);
                $("tbody,tfoot").remove();
                $("table").append(data);
            }
        });
    }
    load_table(1);
    $(".close").on("click",function(){
        $(".popup").removeClass("active");
    });
    $(".add").on("click",function(){
        var id = $(this).closest("tr").data("id");
        $(".add-form").addClass("active");
    });
    $(document).on("click",".edit",function(){
        var id = $(this).closest("tr").data("id");
        var fname = $(this).closest("tr").data("fname");
        var lname = $(this).closest("tr").data("lname");
        $("#edit_data .fname").val(fname);
        $("#edit_data .lname").val(lname);
        $("#edit_data .sid").val(id);
        $(".edit-form").addClass("active");
    });
    function process(target,sid){
        var fname = $(target+" .fname").val().trim();
        var lname = $(target+" .lname").val().trim();
        var sid = (sid == undefined)? "":sid;
        if(fname == "" || lname == ""){
            $(target+" .warn").html("<div class='alert alert-danger'>first name or last name is invalid.</div>");
            setTimeout(() => {
                $(target+" .warn").html("");
            }, 4000);
        }else{
            $.ajax({
                url: "data_process.php",
                type: "POST",
                data: {target:target,fname:fname,lname:lname,sid:sid},
                success: function(data){
                    if(data == 1){
                        $(".add-form,.edit-form").removeClass("active");
                        $(target+"").trigger("reset");
                        load_table(1);
                    }else{
                        $(target+" .warn").html("<div class='alert alert-danger'>"+data+"</div>");
                        setTimeout(() => {
                            $(target+" .warn").html("");
                        }, 4000);
                    }
                }
            });
        }
    }
    $("#add_data").on("submit",function(e){
        e.preventDefault();
        process("#add_data");
    });
    $("#edit_data").on("submit",function(e){
        e.preventDefault();
        var sid = $(".sid").val();
        if(sid == ""){
            $("#edit_data .warn").html("<div class='alert alert-danger'>id is missing.</div>");
            setTimeout(() => {
                $("#edit_data .warn").html("");
            }, 4000);
        }else{
            process("#edit_data",sid);
        }
    });
    $(document).on("click",".delete",function(){
        var id = $(this).closest("tr").data("id");
        if(confirm("are you sure you want to delete this record ?")){
            $.ajax({
                url: "data_process.php",
                type: "POST",
                data: {target:"delete",sid:id},
                success: function(data){
                    if(data == 1){
                        load_table(1);
                    }else{
                        $("table .warn").html("<div class='alert alert-danger'>"+data+"</div>");
                        setTimeout(() => {
                            $("table .warn").html("");
                        }, 4000);
                    }
                }
            });
        }
    });
    $("#search").on({
        "submit" : function(e){
            e.preventDefault();
        },
        "keyup" : function(e){
            var term = $(".search").val().trim();
            load_table(1,term);
        }
    });
    $(document).on("click",".ajax-pagi",function(){
        var page = $(this).data("page");
        var term = $(".search").val();
        load_table(page,term);
    });
});