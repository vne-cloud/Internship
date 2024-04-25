document.addEventListener('DOMContentLoaded', ()=>{
function foo() {
    var boxes = document.getElementsByClassName('text-avatar');
    var tmp = 0;
    for (var i = 0; i < boxes.length; i++) {
      if (boxes[i].offsetHeight > tmp) {
        tmp = boxes[i].offsetHeight;
      }
    }
    for (var z = 0; z < boxes.length; z++) {
      boxes[z].style.height = tmp + "px";
    }
  }
});