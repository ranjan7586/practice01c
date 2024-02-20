$(document).ready(() => {

    $('.date').datepicker({
        dateFormat: "yy-mm-dd   ",
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+0'
    });


    let checkedLength = 0;
    let checkboxArr = [];
    console.log("hio");
    console.log("fwefewfdew");

    const count = 0;
    $("#select_all").change(function () {
        $(".raw_check").prop('checked', $(this).prop("checked"));
        if ($(this).prop("checked") == true) {
            $('.delete_all_btn').css('display','block');
            let nodelist = $(".raw_check");
            let nodeArr = jQuery.makeArray(nodelist);
            nodeArr.forEach(function (item) {
                if (!checkboxArr.includes(item.value)) {
                    checkboxArr.push(item.value)
                }
            })
            console.log(checkboxArr);

        }
        else if ($(this).prop("checked") == false) {
            $('.delete_all_btn').css('display','none')
            checkboxArr = [];
            console.log(checkboxArr);

        }
        checkedLength = $(".raw_check").length;
    })

    $(".raw_check").change(function () {
        checkedLength = $(".raw_check:checked").length;
        if ($(this).prop("checked") == true) {
            $('.delete_all_btn').css('display','block');
            if (!checkboxArr.includes($(this).val())) {
                checkboxArr.push($(this).val());
            }
            console.log(checkboxArr);

        }
        else if ($(this).prop("checked") == false) {
            $('.delete_all_btn').css('display','none')
            let pos = checkboxArr.indexOf($(this).val());
            if (pos > -1) {
                checkboxArr.splice(pos, 1);
            }
            console.log(checkboxArr);
        }






        if ($(".raw_check").length == $(".raw_check:checked").length
        ) {
            $("#select_all").prop("checked", true);
        }
        else {
            $("#select_all").prop("checked", false);

        }
        console.log($(this).parent().parent().children());

    })


    //delete handle
    $(".delete_btn").click(function () {
        const deleteAsk = confirm("Are you sure to delete this data !")
        let sx = $(this);
        let sxl = $(this).length;
        let dataId = $(this).data("id");
        console.log(dataId);
        if (deleteAsk) {
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: {
                    dataId: dataId
                },
                success: function (response) {
                    console.log(response);
                    alert("Item deleted");
                    $('body').load('backendfetch.php');
                }
            })
        }

    })


    $(".edit_btn").click(function () {
        let dataId = $(this).data("id");
        window.location.href = `updateview.php?mode=edit&id=${dataId}`;

    })







    console.log("ooop");


    //pop up view
    $(".view_btn").click(function (e) {
        console.log($(this));
        let dataId = $(this).data("id");
        $.ajax({
            url: 'delete.php',
            type: "POST",
            data: {
                viewdataId: dataId,
                operation: "view"
            },
            success: function (response) {
                console.log(response);
                let data = JSON.parse(response);
                console.log(data);
                $(".container").fadeOut();
                $(".delete_new").fadeOut();
                $(".view_sec").css('display', 'block');
                $("#firstname").html(data.firstname)
                $("#lastname").html(data.lastname)
                $("#phone").html(data.phone)
                $("#email").html(data.email)
                $("#gender").html(data.gender)
                $("#language").html(data.language)
                $("#country").html(data.country)
                $('.view_cancel').click(() => {
                    $(".view_sec").css('display', 'none');
                    $(".container").fadeIn('slow');
                    $(".delete_new").fadeIn('slow');

                })

            }
        })

    })

    $('.delete_all_btn').click(function () {
        console.log("check ", checkedLength);
        if (checkedLength === 0) {
            checkboxArr = [];
            alert("Please select items to delete");
        }

        console.log(checkedLength);
        console.log(checkboxArr);
        let confirmAgain;
        if (checkedLength > 0) {

            confirmAgain = confirm("Are you sure to delete these selected items");
        }
        if (checkedLength > 0 && confirmAgain) {
            window.location.href = `deleteselected.php?mode=delete&dataid=${checkboxArr}`;
        }



    })


    //search functionality
    $(".search_btn").on('click',function(){
        let data=$('#search').val();
        let fromDate=$('#fromdate').val();
        let toDate=$('#todate').val();
        let filterDate=$('#filterdate').val();
        // if(filterDate!="" && (fromDate || toDate)){
        // if((fromDate && !toDate || (!fromDate && toDate))){
        //     alert("Please select both starting and ending date");
        //     return;
        // }
        // }
        console.log(fromDate,toDate);
        let allData={
            searchstr:data,
            fromDate:fromDate,
            toDate:toDate,
            filterDate:filterDate
        }
        console.log(JSON.stringify(allData));
        

        // if(data==""){
        //     alert("Please insert your query for searching");
        //     $('#search').focus();
        // }
        // else{
        // }
        window.location.href=`backendfetch.php?mode=search&data=${JSON.stringify(allData)}`;
        
    })


    //all record view again

    $(".all_record_btn").on('click',function(){
        window.location.href=`backendfetch.php`;
    })

    //search filter by date





})


