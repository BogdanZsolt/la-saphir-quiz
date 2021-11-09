<script>
  import quiz from "../stores/quiz";
  import Loading from "../Loading.svelte";
</script>

<ul>
  {#each $quiz as item}
    <h3 class="title">{item.question}</h3>
    <p>
      Select
      {#if item.number_of_choices > 1}
        up to {item.number_of_choices}
        options
      {:else}
        {item.number_of_choices}
        option
      {/if}
    </p>

    {#each item.answers as answer}
      <h4 class="answer">{answer.answer}</h4>
      <h5 class="reaction">{answer.reaction}</h5>
    {/each}
  {:else}
    <Loading />
  {/each}
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
