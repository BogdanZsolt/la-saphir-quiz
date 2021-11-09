<script>
  import { Tabs, TabList, TabPanel, Tab } from "./components/tabs";
  import categories from "./stores/categories";
  import quiz from "./stores/quiz";
  import Loading from "./Loading.svelte";
</script>

<Tabs>
  <TabList>
    {#each $categories as tab}
      <Tab>{tab}</Tab>
    {:else}
      <Loading />
    {/each}
  </TabList>

  {#each $categories as tab}
    <TabPanel>
      <h2>{tab} panel</h2>
    </TabPanel>
  {/each}
</Tabs>
