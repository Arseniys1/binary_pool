import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

const api_token = 'qHCmgjR6SmuwP0RE0KlEXf86tZNuzFWl';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: 'http://localhost:6001',
    auth: { headers: { 'Authorization': 'Bearer ' + api_token } }
});

window.Echo.join('chat.2').here((users) => {
    console.log('here ', users);
}).joining((user) => {
    console.log('user join ', user);
}).leaving((user) => {
    console.log('user leave ', user);
}).listen('ChatMessage', (e) => {
    console.log('ChatMessage ', e);
});

window.Echo.private('user.1').listen('UserEvent', (e) => {
    console.log('UserEvent ', e);
});

setTimeout(() => {
    axios({
        method: 'post',
        data: {
            id: '1-2',
            text: 'Hello!',
        },
        headers: {
            'Authorization': 'Bearer ' + api_token,
        },
        url: 'http://localhost:8000/api/v2/sendMessage',
    });
}, 1000);
