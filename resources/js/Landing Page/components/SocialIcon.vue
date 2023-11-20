<script setup>
/* import Swal from 'sweetalert2'; */
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head,Link,usePage,router,useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({
    href:{
        type:String
    },
    social_name:{
        type:String,
    },
    alt:{
        type:String,
    },
    isModal:{
        type:Boolean,
        default:false
    },
    isLogin:{
        type:Object,
    },
});

//---Modal Section----
const confirming = ref(false);
    
const confirm = () => {
    confirming.value = true;
};

const closeModal = () => {
    confirming.value = false;
};
//LOGIN MODAL
const confirmingLogIn = ref(false);
    
const confirmLogIn = () => {
    confirmingLogIn.value = true;
};

const closeModalLogIn = () => {
    confirmingLogIn.value = false;
};

const loginUser = () => {
    router.get(route('login'));
}
const loginClient = () => {
    router.get(route('client.login'));
}
const loginCoach = () => {
    router.get(route('coach.login'));
}
</script>

<template>
    <div class="social mt-2">
        <div v-if="isModal">
            <button @click="confirm()"><img  src="/storage/img/welcome-page/calendar.svg"  :alt="props.alt"/></button>
            <button @click="confirmLogIn()"><img  src="/storage/img/welcome-page/login.svg"  :alt="props.alt"/></button>
        </div>
        <div v-else>
            <div v-if="props.social_name === 'instagram'">
                <a :href="props.href" target='_blank' rel='noopener noreferrer'><img src="/storage/img/welcome-page/insta.svg"  :alt="props.alt"/></a>
            </div>
            <div v-if="props.social_name === 'facebook'">
                <a :href="props.href" target='_blank' rel='noopener noreferrer'><img src="/storage/img/welcome-page/facebook.svg"  :alt="props.alt"/></a>
            </div>
        </div>
    </div>
        
    <Modal :show="confirming" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                HORARIOS
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                LUNES - VIERNES : 7:00am - 8:00pm, SÁBADO: 8:00am - 11:00am
            </p>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                DOMINGO: CERRADO
            </p>

            <div class="mt-1 flex justify-end">
                <SecondaryButton @click="closeModal"> Close </SecondaryButton>
            </div>
        </div>
    </Modal>
    <Modal :show="confirmingLogIn" @close="closeModalLogIn">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Welcome Back
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Tell us who you are?
            </p>
            
            <div class="mt-1 flex justify-center space-x-4" v-if="isLogin.user == false && isLogin.client == false && isLogin.coach == false">
                <PrimaryButton @click="loginUser"> Employee </PrimaryButton>
                <PrimaryButton  @click="loginClient"> Client </PrimaryButton>
                <PrimaryButton  @click="loginCoach"> Coach </PrimaryButton>
            </div>
            <div v-else class="mt-1 flex justify-center space-x-4">
                <PrimaryButton @click="loginUser" v-if="isLogin.user == true"> Employee Dashboard</PrimaryButton>
                <PrimaryButton  @click="loginClient" v-if="isLogin.client == true"> Client Dashboard</PrimaryButton>
                <PrimaryButton  @click="loginCoach" v-if="isLogin.coach == true"> Coach Dashboard</PrimaryButton>
            </div>

            <div class="mt-1 flex justify-end">
                <SecondaryButton @click="closeModalLogIn"> Close </SecondaryButton>
            </div>
        </div>
    </Modal>
</template>

<style>
.social{
    display: inline-flex;
}
.social a , .social button {
  width: 42px;
  height: 42px;
  background: rgba(217, 217, 217, 0.1);
  display: inline-flex;
  border-radius: 50%;
  margin-right: 6px;
  align-items: center;
  justify-content: center;
  line-height: 1;
  border: 1px solid rgba(255, 255, 255, 0.5);
}

.social a::before ,.social button::before {
  content: "";
  width: 42px;
  height: 42px;
  position: absolute;
  background-color: #ffffff;
  border-radius: 50%;
  transform: scale(0);
  transition: 0.3s ease-in-out;
}
.social a:hover::before , .social button:hover::before {
  transform: scale(1);
}
 .social a img , .social button img{
  width: 40%;
  z-index: 1;
  transition: 0.3s ease-in-out;
}
.social a:hover img , .social button:hover img {
  filter: brightness(0) saturate(100%) invert(0%) sepia(7%) saturate(98%)
    hue-rotate(346deg) brightness(95%) contrast(86%);
}

</style>