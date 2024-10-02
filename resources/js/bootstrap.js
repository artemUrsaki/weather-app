import axios from 'axios';
import select2 from 'select2';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

select2();