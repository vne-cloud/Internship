

document.addEventListener('DOMContentLoaded', ()=>{
    var acc = document.getElementsByClassName("accordion");
    var i;
    
    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
    
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            console.log(panel);
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
});