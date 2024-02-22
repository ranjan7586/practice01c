$(document).ready(() => {
    viewAllRecords();

})
console.log($('.edit_btn'));
console.log(document.querySelector('.edit_btn'))

//view all the records
function viewAllRecords() {
    $('#ex_css').attr('href','css/index.css');
    console.log("lo");
    $.ajax({
        url: 'server.php',
        type: 'post',
        data: { mode: 'view' },
        success: function (response) {
            $(".result").html(response);
            $('.edit_btn').on("click", handleEdit);
            $(".search_btn").on('click', handleSearch);
            $('.date').datepicker({
                dateFormat: "yy-mm-dd   ",
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0'
            });
            handleCheck();
        }

    })
}




//delete single data
function deleteData(data) {
    console.log(data);
    console.log("hi");
    const deleteAsk = confirm("Are you sure to delete this data !");
    if (deleteAsk) {
        $.ajax({
            url: 'server.php',
            type: 'POST',
            data: { dataId: data, mode: 'delete' },
            success: function (response) {
                // console.log(response);
                alert("Item deleted");
                viewAllRecords();
            }
        })
    }
}


//search functionality
function handleSearch() {
    let data = $('#search').val();
    let fromDate = $('#fromdate').val();
    let toDate = $('#todate').val();
    let filterDate = $('#filterdate').val();
    console.log(fromDate, toDate);
    let allData = {
        searchstr: data,
        fromDate: fromDate,
        toDate: toDate,
        filterDate: filterDate
    }
    console.log(JSON.stringify(allData));

    $.ajax({
        url: 'server.php',
        type: 'post',
        data: {
            allData: JSON.stringify(allData),
            operation: "search",
        },
        success: function (response) {
            console.log(response);
            $(".result").html(response);
            $(".search_btn").on('click', handleSearch);
            $('.date').datepicker({
                dateFormat: "yy-mm-dd   ",
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0'
            });
            handleCheck();

        }
    })

}


//view data in a pop up manner
function viewData(data) {
    console.log(data);

    $.ajax({
        url: 'server.php',
        type: 'POST',
        data: { dataId: data, mode: 'viewspecific' },
        success: function (response) {
            $('.view_sec').html(response);
            $('.view_sec').css('display', 'block');
        }
    })
}

//cancel view pop up
function viewCancel() {
    $('.view_sec').css('display', 'none');
}

//checkbox handle
function handleCheck() {
    $("#select_all").change(function () {
        console.log("olp");

        $(".raw_check").prop('checked', $(this).prop("checked"));
        if ($(this).prop("checked") == true) {
            $('.delete_all_btn').css('display', 'block');
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
            $('.delete_all_btn').css('display', 'none')
            checkboxArr = [];
            console.log(checkboxArr);

        }
        checkedLength = $(".raw_check").length;
    })


    $(".raw_check").change(function () {
        checkedLength = $(".raw_check:checked").length;
        if ($(this).prop("checked") == true) {
            $('.delete_all_btn').css('display', 'block');
            if (!checkboxArr.includes($(this).val())) {
                checkboxArr.push($(this).val());
            }
            console.log(checkboxArr);
    
        }
        else if ($(this).prop("checked") == false) {
            $('.delete_all_btn').css('display', 'none')
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
}






let checkedLength = 0;
let checkboxArr = [];
console.log("hio");
console.log("fwefewfdew");

const count = 0;


//delete selected items

function deleteSelected(){
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
    if(confirmAgain){
        $.ajax({
            url:'server.php',
            type:'POST',
            data:{data:checkboxArr,mode:'deleteselect'},
            success:function(response){
                console.log(response);
                if(response){
                    alert("Items deleted successfully");
                    viewAllRecords();
                }
                
            }
        })
    }
}



function handleEdit() {
    console.log($(this).data("id"));
    dataId = $(this).data("id");
    $.ajax({
        url: 'server.php',
        type: 'post',
        data: { mode: 'editview', dataId: dataId },
        success: function (response) {
            console.log(response);

        }

    })


}


function cancelAdd(){
    viewAllRecords();
    $('#ex_css').attr('href','css/index.css');
}

//add new user
function addNewUser(){
    $('#firstname').focus();
    $.ajax({
        url:'server.php',
        type:"POST",
        data:{mode:'createnewuser'},
        success:function (response){
            console.log(response);
            $('.result').html(response);
            $('#ex_css').attr('href','css/resgistration.css');
            $('#date').datepicker({
                dateFormat: "yy-mm-dd   ",
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0'
            });
            let action='create';
            formValidateAdd();

        }
    })
}



let passwordPrevvalue;
let passwordPostValue;

//add new user
function updateUser(data){

    $.ajax({
        url:'server.php',
        type:"POST",
        data:{mode:'updateuser',data:data},
        success:function (response){
            console.log(response);
            $('.result').html(response);
            $('#ex_css').attr('href','css/resgistration.css');
            $('#date').datepicker({
                dateFormat: "yy-mm-dd   ",
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0'
            });
            passwordPrevvalue = $('#password').val();
            formValidateUpdate();
        }
    })
}


//form validation add
function formValidateAdd() {
    console.log("enters");
    $('#firstname').focus();
    let genderValue = "";
    $("#formOne").submit(function (event) {
        event.preventDefault();
        console.log($("#firstname").val());
        let stop = true;
        console.log("567");
        let passwordValue = $("#password").val().toString();
        let passwordValidateResult = passwordValidate(passwordValue);
        let imageValidateResult = imageHandle($("#image").val().toString());
        let tgh = $("#image");
        console.log(tgh);
        let emailValidateCheck = handleEmail();


        let passWordLength = passwordValue.length;
        genderValue = $('input[name="gender"]:checked').val();
        console.log(genderValue);

        let phone_no = $("#phone_number").val().toString().length;
        if ($("#firstname").val() == "") {
            valueCheck("#firstname", "firstname", "Please enter your");
        }
        else if ($("#lastname").val() == "") {
            valueCheck("#lastname", "lastname", "Please enter your");
        }
        else if ($("#phone_number").val() == "") {
            valueCheck("#phone_number", "phone number", "Please enter your");
        }
        else if (phone_no < 10 || phone_no > 10) {
            alert("phone number should contain only 10 digits ");
            $(`#phone_number`).focus();
        }
        else if ($("#email").val() == "") {
            valueCheck("#email", "email", "Please enter your");
            $(`#email`).focus();
        }
        else if (!emailValidateCheck) {
            alert("Invalid email! Please enter a valid email ");
            $(`#email`).focus();
        }
        else if ($("#password").val() == "") {
            valueCheck("#password", "password", "Please enter your");
        }
        else if (passWordLength < 8) {
            alert("Please choose a strong password containing minimum 8 chracters");
            $(`#password`).focus();
        }
        else if (!passwordValidateResult) {
            alert("Please choose a strong password including any special chracter and a numeric. ex - Password123@");
            $(`#password`).focus();
        }
        else if ($("#cpassword").val() == "") {
            valueCheck("#cpassword", "password", "Please confirm your")
        }
        else if ($("#password").val() != $("#cpassword").val()) {
            alert("Passwords should be same");
            $(`#cpassword`).focus();
        }
        else if ($('#date').val() == "") {
            alert("Please enter your date of birth");
            $(`#date`).focus();
        }
        else if (genderValue == undefined) {
            valueCheck(".gender", "gender", "Please select your");
        }
        else if ($('input[name="language[]"]:checked').val() == undefined) {
            valueCheck(".language", "language", "Please choose your");
        }
        else if ($("#country option:selected").val() == "") {
            valueCheck("#country", "country", "Please select your");
        }
        else if ($("#image").val() == "") {
            valueCheck("#image", "image", "Please upload your");
        }
        else if (imageValidateResult) {
            alert("Please insert images with format of .jpg or .jpeg, .png");
            $(`${"#image"}`).focus();
        }
        else if ($("#about_user").val() == "") {
            valueCheck("#about_user", "about yourself", "Please tell me something");
        }
        else {
            stop = false;
            let formData = new FormData(document.getElementById('formOne'));
            console.log("form");
            console.log(formData);
            formData.append('mode', 'createrecord');

            $.ajax({
                url: 'server.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    console.log(typeof(response));
                    if((response.includes("already exists"))){ 
                        alert(response);
                        
                    }
                    else{
                        alert("Registration Sucessful");
                        $('#ex_css').attr('href','css/index.css');
                        viewAllRecords();
                    }

                },
                error: function (error) {
                    console.log(error);
                    console.log("error");

                }
            })
        }
        if (stop) {
            event.preventDefault();
        }
    })

}

//form validation update
let imageValidateResult = false;
function formValidateUpdate() {
    let genderValue = "";
    $("#formOne").submit((event) => {
        event.preventDefault();
        console.log(event);
        passwordPostValue = $('#password').val();
        let stop = true;
        console.log("567");
        let passwordValue = $("#password").val().toString();
        let passwordValidateResult = passwordValidateUpdate(passwordValue);
        if ($("#image").val()) {
            imageValidateResult = imageHandleUpdate($("#image").val().toString());
        }
        let tgh = $("#image");
        console.log(tgh);
        let emailValidateCheck = handleEmail();


        let passWordLength = passwordValue.length;
        genderValue = $('input[name="gender"]:checked').val();
        console.log(genderValue);

        let phone_no = $("#phone_number").val().toString().length;
        if ($("#firstname").val() == "") {
            valueCheck("#firstname", "firstname", "Please enter your");
        }
        else if ($("#lastname").val() == "") {
            valueCheck("#lastname", "lastname", "Please enter your");
        }
        else if ($("#phone_number").val() == "") {
            valueCheck("#phone_number", "phone number", "Please enter your");
        }
        else if (phone_no < 10 || phone_no > 10) {
            alert("phone number should contain only 10 digits ");
            $(`#phone_number`).focus();
        }
        else if ($("#email").val() == "") {
            valueCheck("#email", "email", "Please enter your");
            $(`#email`).focus();
        }
        else if (!emailValidateCheck) {
            alert("Invalid email! Please enter a valid email ");
            $(`#email`).focus();
        }
        else if ($("#password").val() == "") {
            valueCheck("#password", "password", "Please enter your");
        }
        else if (passWordLength < 8) {
            alert("Please choose a strong password containing minimum 8 chracters");
            $(`#password`).focus();
        }
        else if (!passwordValidateResult) {
            alert("Please choose a strong password including any special chracter and a numeric. ex - Password123@");
            $(`#password`).focus();
        }
        else if ($("#cpassword").val() == "") {
            valueCheck("#cpassword", "password", "Please confirm your")
        }
        else if ($("#password").val() != $("#cpassword").val()) {
            alert("Passwords should be same");
            $(`#cpassword`).focus();
        }
        else if ($('#date').val() == "") {
            alert("Please enter your date of birth");
            $(`#date`).focus();
        }
        else if (genderValue == undefined) {
            valueCheck(".gender", "gender", "Please select your");
        }
        else if ($('input[name="language[]"]:checked').val() == undefined) {
            valueCheck(".language", "language", "Please choose your");
        }
        else if ($("#country option:selected").val() == "") {
            valueCheck("#country", "country", "Please select your");
        }
        else if ($("#image").val() == "" && $("#image")[0].defaultValue == "") {
            valueCheck("#image", "image", "Please upload your");
        }
        else if (imageValidateResult) {
            alert("Please insert images with format of .jpg or .jpeg, .png");
            $(`${"#image"}`).focus();
        }
        else if ($("#about_user").val() == "") {
            valueCheck("#about_user", "about yourself", "Please tell me something");
        }
        else {
            stop = false;
            let formData = new FormData(document.getElementById('formOne'));
            console.log("form");
            console.log(formData);
            formData.append('mode', 'update');
            $.ajax({
                url: 'server.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    console.log(typeof (response));
                    if ((response.includes("already exists"))) {
                        alert(response);
                    }
                    else {
                        alert("Updation Sucessful");
                        viewAllRecords();
                    }

                },
                error: function (error) {
                    console.log(error);
                    console.log("error");

                }
            })
        }
        if (stop) {
            event.preventDefault();
        }
    })

}


//value check
function valueCheck(inputField, fieldName, message) {
    alert(`${message} ${fieldName}`);
    $(`${inputField}`).focus();
}

//password validation
const passwordValidate = function (password) {
    console.log(password);

    let flag = false;
    const specialChars = '[`!@#$%^&*()_+-=[]{};\':"\\|,.<>/?~]/';
    const specialAppear = specialChars.split('').some((e) => {
        return password.includes(e);
    })
    console.log(specialAppear);

    const specialNumbers = '1234567890';
    const numberAppear = specialNumbers.split('').some((e) => {
        return password.includes(e);
    })
    const capAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const calAppear = capAlphabet.split('').some((e) => {
        return password.includes(e);
    })


    if (specialAppear && numberAppear && calAppear) {
        flag = true;
    }
    return flag;

}

//image validation
const imageHandle = function (image) {
    console.log(image);

    const arr = ['.jpg', '.jpeg', '.png']
    let dotIndex = image.indexOf('.');
    let l = image.length;
    let extension = image.substring(dotIndex, l)
    if (arr.includes(extension)) {
        return 0;
    }
    else
        return 1;
}


//image validation

const handleEmail = function () {
    console.log("hi");

    let flag = 1;
    let count = 0;
    const email = $("#email").val().toString();
    let n = email.length - 1;


    const specialChars = '[`!#$%^&*()_+-=[]{};\':"\\|,<>/?~]/';
    const specialAppear = specialChars.split('').some((e) => {
        return email.includes(e);
    })

    const domainArr = ['com', 'in', 'org', 'info', 'gov', 'co', 'edu', 'net', 'biz'];
    let dotIndex = email.indexOf('.');
    let sub = email.substring(dotIndex + 1, n + 1);
    let checkdomain = domainArr.includes(sub);
    console.log(domainArr.includes(sub));



    if (email.includes("@") && email.includes(".")) {
        if (specialAppear) {
            flag = 1;
        }
        for (let i = 0; i < email.length; i++) {
            if (email[i] == "@") {
                count++;
            }
            if ((email[0] == '@') || (email[0] == ".") || (email[n] == "@") || (email[n] == ".") || (email[i] == '.' && email[i + 1] == '.') || (email[i] == '@' && email[i + 1] == '@') || (email[i] == '@' && email[i + 1] == '.') || (email[i] == '.' && email[i + 1] == '@'))
                flag = 1;
            else if (count > 1)
                flag = 1;
            else
                flag = 0;

        }
    }

    if (!checkdomain) {
        flag = 1;
    }
    console.log(flag);

    if (flag == 1) {
        return 0;
    }
    else
        return 1;

}

//update password validation
const passwordValidateUpdate = function (password) {
    console.log(password);

    let flag = false;
    const specialChars = '[`!@#$%^&*()_+-=[]{};\':"\\|,.<>/?~]/';
    const specialAppear = specialChars.split('').some((e) => {
        return password.includes(e);
    })
    console.log(specialAppear);

    const specialNumbers = '1234567890';
    const numberAppear = specialNumbers.split('').some((e) => {
        return password.includes(e);
    })
    const capAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const calAppear = capAlphabet.split('').some((e) => {
        return password.includes(e);
    })

    if (passwordPrevvalue == passwordPostValue) {
        flag = true;
    }
    else if (specialAppear && numberAppear && calAppear) {
        flag = true;
    }
    return flag;

}


//image handle update
const imageHandleUpdate = function (image) {
    console.log(image);
    if (($("#image").val() == "") && ($("#image")[0].defaultValue != '')) {
        image = $("#image")[0].defaultValue;
    }
    console.log(image);

    const arr = ['.jpg', '.jpeg', '.png']
    let dotIndex = image.lastIndexOf('.');
    let l = image.length;
    let extension = image.substring(dotIndex, l)
    if (arr.includes(extension)) {
        return 0;
    }
    else
        return 1;
}

function handleImage(){
    console.log("hi");
    $('.img_prev').hide();
    
}





