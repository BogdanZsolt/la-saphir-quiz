document.addEventListener('DOMContentLoaded', ()=>{
 if(document.querySelector('#add-field')){
  const addField = document.querySelector('#add-field')
  const removeField = document.querySelector('#remove-field')
  const tBody = document.querySelector('tbody')

  addField.onclick = () => {
   let newField = document.createElement('tr')
   newField.innerHTML = '<th style=""><label for="quiz_answer">Answer </label></th><td><textarea class="widefat" name="quiz_answer[]" id="quiz_answer"></textarea></td>'
   tBody.appendChild(newField)
  }

  removeField.onclick = () => {
   const inputTags = tBody.getElementsByTagName('tr')
   console.log(inputTags.length)
   if(inputTags.length > 3){
    tBody.removeChild(inputTags[(inputTags.length)-1])
   }
  }

 }

})