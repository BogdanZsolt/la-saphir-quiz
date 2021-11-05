import App from './App.svelte';

if(document.querySelector('#lsq_load')){
	const app = new App({
		target: document.querySelector('#lsq_load'),
	});
}

export default app;