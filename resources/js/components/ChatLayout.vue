<template>
    <h3 class=" text-center">Messaging | User: {{ user.name }}</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="inbox_chat">
                    <div v-for="item in users">
                        <div v-if="user.id !== item.id" class="chat_list">
                            <div  class="chat_people">
                                <div class="chat_img"><img src="https://ptetutorials.com/images/user-profile.png"
                                                           alt="sunil"></div>
                                <div class="chat_ib">
                                    <h5>{{ item.name }} <span class="chat_date">Dec 25</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mesgs">
                <div class="msg_history" ref="hasScrollToBottom">
                    <div v-for="message in messages">
                        <div v-if="user.id !== message.user.id" class="incoming_msg">
                            <div class="incoming_msg_img"><img src="https://ptetutorials.com/images/user-profile.png"
                                                               alt="sunil">
                            </div>
                            <div class="received_msg">
                                <div class="received_withd_msg">
                                    <p>{{ message.message }}</p>
                                    <span class="time_date"> 11:01 AM | June 9</span>
                                </div>
                            </div>
                        </div>
                        <div v-else class="outgoing_msg">
                            <div class="sent_msg">
                                <p>{{ message.message }}</p>
                                <span class="time_date"> 11:01 AM | June 9</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input v-model="newMessage" @keyup.enter="checkEmptyMessage" type="text" class="write_msg" name="message"
                               placeholder="Type a message"/>
                        <button @click="checkEmptyMessage" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o"
                                                                                           aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, onUpdated, ref} from "vue";

export default {
    el: "#app",
    props: ['user'],

    setup(props) {
        let messages = ref([])
        let newMessage = ref('')
        let hasScrollToBottom = ref('')
        let users = ref([])

        onMounted(() => {
            fetchMessages()
            allUser()
        })

        onUpdated(() => {
            scrollBottom()
        })

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                messages.value.push({
                    message: e.message.message,
                    user: e.user
                })
            })

        const checkEmptyMessage = () => {
            if (newMessage.value == null || newMessage.value.trim() === '') {
                console.log('empty')
            } else {
                addMessage();
            }
        }

        const fetchMessages = async() => {
            axios.get('/messages')
                .then(res => {
                    messages.value = res.data;
                })
        }


        const addMessage = async() => {
            let user_message = {
                user: props.user,
                message: newMessage.value
            }
            messages.value.push(user_message)
            axios.post('/message', user_message)
                .then(res => {
                    console.log(res.data)
                })
            newMessage.value = ''
        }

        const scrollBottom = () => {
            if (messages.value.length > 1) {
                let el = hasScrollToBottom.value;
                el.scrollTop = el.scrollHeight;
            }
        }

        const allUser = () => {
            axios.get('/users')
                .then(res => {
                    users.value = res.data;
                })
        }

        return {
            messages,
            newMessage,
            checkEmptyMessage,
            fetchMessages,
            hasScrollToBottom,
            users
        }
    },
}


</script>
