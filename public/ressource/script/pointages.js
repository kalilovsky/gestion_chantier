
let popup = document.getElementById("editPopup");
let matriculeSelect = document.getElementById("matriculeOuvrier");
let nomPrenomSelect = document.getElementById("nomPrenomOuvrier");
let heureDebut = document.getElementById('heureDebut');
let heureFin = document.getElementById('heureFin');
let form = document.getElementById('editPopupForm');
document.getElementById("addPointage").addEventListener('click',(e)=>{
    e.preventDefault();
    popup.classList.toggle("visible");
})

document.getElementById('popUpCloseBtn').addEventListener('click',(e)=>{
    popup.classList.toggle("visible");
    form.reset();
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
        form.reset();
    }
}

document.getElementById('datePointage').addEventListener('change',(e)=>{
    if(e.target.value != "") {
        heureDebut.disabled = false;
    }else{
        heureDebut.disabled = true;
    }
})

heureDebut.addEventListener('change',(e)=>{
    if(e.target.value != ''){
        heureFin.disabled = false;
        heureFin.min = e.target.value;
    }else{
        heureFin.disabled = true;
        heureFin.min = '';
    }
})

form.addEventListener('submit',(e)=>{
    e.preventDefault();
    let [hoursDiff , minDiff] = getDurationOfWork();
    if(hoursDiff > 0 || minDiff > 0){
        let formData = new FormData(e.target);
        fetch(e.target.action,{method:'post',body:formData})
        .then(result=>result.json())
        .then(data=>{
            if(data.message == 'success'){
                location.reload();
            }else{
                document.getElementById('message').innerHTML = data.message;
            }
        })
    }else{
        document.getElementById('message').innerHTML = "L'heure de fin est inférieur à l'heure de début !";
    }
})

function getDurationOfWork(){
    let start = heureDebut.value.split(':');
    let end = heureFin.value.split(':');
    let startHour = new Date(0,0,0,start[0],start[1],0)
    let endHour = new Date(0,0,0,end[0],end[1],0)
    console.log(startHour);
    console.log(endHour);
    let timeDiff = endHour.getTime() - startHour.getTime()
    let hourDiff = Math.floor(timeDiff/ 1000 / 60 / 60);
    timeDiff -= hourDiff*1000*60*60;
    let minDiff = Math.floor(timeDiff/ 1000 / 60 );
    if(minDiff < 0 || hourDiff < 0) return [false,false]
    return [hourDiff,minDiff];
}
