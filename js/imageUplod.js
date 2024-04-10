function triggerclick(){
    document.querySelector('#imageupd').click();
} 

function displayimage(e){ 
    if(e.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
            document.querySelector('#photodisplay').setAttribute('src', e.target.result); 
        }
        reader.readAsDataURL(e.files[0]);
    }
}