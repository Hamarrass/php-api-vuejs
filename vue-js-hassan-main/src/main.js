import { createApp } from 'vue'
import App from './App.vue'
var cors = require('cors')

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.min.js"
import "./assets/Global.css"

import axios from 'axios'



axios.defaults.baseURL = "http://localhost/php-hassan-master"

import { library } from '@fortawesome/fontawesome-svg-core'
import { faHatWizard } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faHatWizard)

// .component('font-awesome-icon', FontAwesomeIcon)
createApp(App).use(cors).mount('#app')
