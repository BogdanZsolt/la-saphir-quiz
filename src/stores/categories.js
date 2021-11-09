import { writable } from "svelte/store";
import getQuiz from "../tools/getQuiz";
const store = writable([], () => {
  setCategories();
  return () => {};
});

const setCategories = async () => {
  let quizData = await getQuiz();
  if (quizData) {
    let categories = [];
    console.log(quizData);
    quizData.forEach((item) => {
      item.categories.forEach((cat) => {
        if (categories.indexOf(cat.name) < 1) {
          categories.push(cat.name);
        }
      });
    });
    store.set(categories);
    console.log(categories);
  }
};

export default store