
$(document).ready(() => {
    $(`${"#firstname"}`).focus();

    formValidate();
    $('#date').datepicker({
        dateFormat: "yy-mm-dd   ",
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+0'
    });
}
)
// let filetype = selectedFile.file[0].type;
console.log("8520");
function formValidate() {
    let genderValue = "";
    $("#formOne").submit((event) => {
        console.log(event);
        // event.preventDefault();
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
        }
        if (stop) {
            event.preventDefault();
        }
    })

}
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
// console.log(handleEmail);


