
let popup = document.getElementById("editPopup");
let matriculeSelect = document.getElementById("matriculeOuvrier");
let nomPrenomSelect = document.getElementById("nomPrenomOuvrier");
document.getElementById("addPointage").addEventListener('click',(e)=>{
    e.preventDefault();
    popup.classList.toggle("visible");
})

document.getElementById('popUpCloseBtn').addEventListener('click',(e)=>{
    popup.classList.toggle("visible");
})

matriculeSelect.addEventListener('change',(e)=>{
    nomPrenomSelect.value = e.target.value;
})

nomPrenomSelect.addEventListener('change',(e)=>{
    matriculeSelect.value = e.target.value;
})

window.onclick = function (e) {
    if (e.target == document.getElementById("editPopup")) {
        document.getElementById("editPopup").classList.remove("visible");
    }
}