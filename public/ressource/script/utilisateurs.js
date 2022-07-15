Array.from(document.getElementsByClassName("deleteButton")).forEach(item=>{
    item.addEventListener('click',(e)=>{
        if(!confirm('Voulez-vous vraiment effacer ce chantier ?')){
            e.preventDefault();
        }
    })
})