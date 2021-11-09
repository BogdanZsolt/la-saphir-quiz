import url from './url'
export default async() => {
 const response = await fetch(`${url}/wp-json/wp/v2/ls_quiz`).catch(error => console.error(error))
 const quizData = await response.json()
 if(quizData.error){
  return null
 } else {
  console.log(quizData)
  return quizData
 }
}

