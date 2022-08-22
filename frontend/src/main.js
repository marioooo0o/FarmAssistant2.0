import { createApp } from 'vue'
import App from './App.vue'
import BaseButton from './components/ui/BaseButton.vue'
import BaseCard from './components/ui/BaseCard.vue'
import BaseDescriptionCard from './components/ui/BaseDescriptionCard.vue'
import BaseInput from './components/ui/BaseInput.vue'
import BaseLabel from './components/ui/LabelInput.vue'
import router from './router'

import './assets/main.css'

const app = createApp(App)

app.use(router)
app.config.unwrapInjectedRef = true;

app.component('base-button', BaseButton);
app.component('base-card', BaseCard);
app.component('base-description-card', BaseDescriptionCard);
app.component('base-input', BaseInput);
app.component('base-label', BaseLabel);

app.mount('#app')
