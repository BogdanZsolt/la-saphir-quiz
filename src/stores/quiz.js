import { writable } from "svelte/store";
import getQuiz from "../tools/getQuiz";
const store = writable([], ()=>{
 setQuiz()
 return () => {}
})

const flattenQuiz = (data) => {
 return data.map((item) => {
  let id = item.id
  let question = item.title.rendered;
  let number_of_choices = item.number_of_choices
  let questionIndex = item.questionIndex
  let categories = [];
  let category = []
  item.categories.forEach((cat) => {
   category['name'] = cat.name
   category['id'] = cat.term_id
   categories.push(category);
   category = []
  });
  let answer = [];
  let answers = [];
  for (let i = 0; i < item.answers.length; i++) {
   answer["answer"] = item.answers[i];
   answer["reaction"] = item.reactions[i];
   answers.push(answer);
   answer = [];
  }
  return { id, question, questionIndex, answers, categories, number_of_choices };
 });
};

const setQuiz = async() => {
 let quizData = await getQuiz()
 if(quizData){
  quizData = flattenQuiz(quizData)
  store.set(quizData)
 }
 console.log(quizData)
}

export default store