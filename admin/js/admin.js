document.addEventListener('DOMContentLoaded', ()=>{
 if(document.querySelector('#add-field')){
  const addField = document.querySelector('#add-field')
  const removeField = document.querySelector('#remove-field')
  const tBody = document.querySelector('table.form-table tbody')

  addField.onclick = () => {
   let newField1 = document.createElement('tr')
   let newField2 = document.createElement('tr')
   let serialNumber = tBody.getElementsByTagName('textarea').length
   newField1.innerHTML = `<th style=""><label for="quiz_answer">Answer ${
     serialNumber + 1
   }</label></th><td><textarea class="widefat" name="quiz_answer[]" id="quiz_answer${
     serialNumber + 1
   }"></textarea></td>`;
   newField2.innerHTML = `<th style=""><label for="quiz_reaction">Reaction ${
     serialNumber + 1
   }</label></th><td><input class="widefat" type="text" name="quiz_reaction[]" id="quiz_reaction${
     serialNumber + 1
   }" value="?" /></td></tr>`;
   tBody.appendChild(newField1)
   tBody.appendChild(newField2)
  }

  removeField.onclick = () => {
   const inputTags = tBody.getElementsByTagName('tr')
   if(inputTags.length > 5){
    tBody.removeChild(inputTags[(inputTags.length)-1])
    tBody.removeChild(inputTags[(inputTags.length)-1])
   }
  }

 }

})