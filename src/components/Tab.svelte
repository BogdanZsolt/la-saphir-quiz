<script>
  import { getContext } from "svelte";
  import { TABS } from "./Tabs.svelte";

  const tab = {};
  const { registerTab, selectTab, selectedTab } = getContext(TABS);

  registerTab(tab);
</script>

<button class:selected={$selectedTab === tab} on:click={() => selectTab(tab)}>
  <slot />
</button>

<style lang="scss">
  button {
    background: orange;
    border: 2px;
    border-bottom: 2px solid white;
    border-radius: 5px;
    margin: 0;
    color: #ccc;
  }

  .selected {
    border-bottom: 2px solid teal;
    color: #333;
  }
</style>
