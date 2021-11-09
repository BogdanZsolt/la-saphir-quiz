<script>
  import { onMount } from "svelte";

  const flattenQuiz = (data) => {
    return data.map((item) => {
      let categories = [];
      item.categories.forEach((element) => {
        categories.push(element.name);
      });
      console.log("categories:", categories);
      let answer = [];
      let answers = [];
      let question = item.title.rendered;
      for (let i = 0; i < item.answers.length; i++) {
        answer["answer"] = item.answers[i];
        answer["reaction"] = item.reactions[i];
        answers.push(answer);
        answer = [];
      }
      return { question, answers, categories };
    });
  };

  let data = [];
  const loadQuiz = async () => {
    const res = await fetch("http://quiztest.local/wp-json/wp/v2/ls_quiz");
    const json = await res.json();
    console.log("loadQuiz json:", json);
    const data = flattenQuiz([...json]);
    console.log("loadQuiz data:", data);
    return data;
  };
</script>

<ul>
  {#await loadQuiz()}
    loading...
  {:then data}
    {#each data as item}
      <h3 class="title">{item.question}</h3>
      {#each item.answers as answer}
        <p class="answer">{answer.answer}</p>
        <p class="reaction">{answer.reaction}</p>
      {/each}
    {/each}
  {:catch error}
    <p>something went wrong: {error.message}</p>
  {/await}
</ul>

<style global lang="scss">
  .title {
    margin-bottom: 1rem;
    font-size: 2rem;
    font-weight: 300;
    color: #ff3300;
  }
  .answer {
    margin-bottom: 0.5rem;
    font-size: 1rem;
    font-weight: 400;
    color: palevioletred;
  }
  .reaction {
    margin-bottom: 0.625rem;
    font-size: 0.85rem;
    font-weight: 400;
    color: gray;
  }
</style>
