// Please see documentation at https://docs.microsoft.com/aspnet/core/client-side/bundling-and-minification
// for details on configuring this project to bundle and minify static web assets.

// Write your JavaScript code.


document.addEventListener("input", function (e) {
    // check whether student select dropdown or not.
    if (e.target.id !== "selectStudent") return;

    const selectedStudentId = document.querySelector("#selectStudent").value;
    if (selectedStudentId !== "-1") {
        document.getElementById("getRegistration").click();
    }

})

/* document.addEventListener("click", function (ev) {
    if (ev.target.id !== "grade") return;
    // added 2022-10-03
    ev.preventDefault();

    const selectedStudentId = document.querySelector("#selectStudent").value;
    if (selectedStudentId !== "-1") {

        let btn = document.getElementById("RegisterGrade");
        btn.click();
        return false;
        //document.getElementById("RegisterGrade").click();
        
    }
})
*/