function number_format(number, decimals = 0, dec_point = ".", thousands_sep = ",") {
    number = parseFloat(number).toFixed(decimals);

    let parts = number.split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);

    return parts.join(dec_point);
}

document.addEventListener("DOMContentLoaded", function () {
    let navbarToggler = document.querySelector(".navbar-toggler");
    let navbar = document.querySelector("header .navbar");
    let btnLoginMobile = document.getElementById("btn-mobile-primary");
    navbarToggler.addEventListener("click", function () {
        if (navbarToggler.getAttribute("aria-expanded") === "true") {
            navbar.style.borderRadius = "10px";
            btnLoginMobile.classList.add("btn-linear-primary");
            btnLoginMobile.style.textAlign = "center";
        } else {
            navbar.style.borderRadius = "200px"; // Reset to default
        }
    });
});

$(document).ajaxStart(function () {
    $("#loading-overlay").css("display", "flex");
});

$(document).ajaxStop(function () {
    $("#loading-overlay").css("display", "none");
});

$(".toggle-password").click(function () {
    var destination = $(this).data("destination");
    let input = $("#" + destination);
    let type = input.attr("type") === "password" ? "text" : "password";
    input.attr("type", type);
    if(type == "password") {
        $(this).find("i").removeClass("ti-eye-off");
        $(this).find("i").addClass("ti-eye");
    } else {
        $(this).find("i").removeClass("ti-eye");
        $(this).find("i").addClass("ti-eye-off");
    }
});