/*
if(localStorage.getItem("theme") == "dark"){
    setDarkMode();
    
    if(document.getElementById("darkcheck").checked){
        localStorage.setItem("darkcheck", true);
    }
}

function setDarkMode() {
    let isDark = document.body.classList.toggle("dark");

    if(isDark) {
        setDarkMode.checked = true;
        localStorage.setItem("theme", "dark")
        document.getElementById("darkcheck").setAttribute("checked","checked");

    } else{
        setDarkMode.checked = true;
        localStorage.removeItem("theme","dark");
    }
}
*/

function setDarkMode() {
    document.body.classList.toggle("dark");
}