<script setup>
import SocialIcon from './SocialIcon.vue';
const currentYear = new Date().getFullYear();
</script>
<template>
    
    <footer class="rounded-lg shadow bg-gray-900 m-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div  class="flex items-center mb-4 sm:mb-0">
                    <img src="/storage/img/welcome-page/logo/Logo.png" class="h-8 mr-3" alt="Logo" />
                    <span class="self-center text-2xl mb-4 tracking-tight font-extrabold text-white">SportCity</span>
                </div>
                <span class='navbar-text'>
                    <div class="social-icon">
                        <SocialIcon :href="'https://www.instagram.com/sportc.sv/'" :social_name="'instagram'" :alt="'In'"/>
                        <SocialIcon :href="'https://www.facebook.com/profile.php?id=100054284840887'" :social_name="'facebook'"  :alt="'Fa'"/>
                    </div>
                </span>
            </div>
            <hr class="my-6 sm:mx-auto border-gray-700 lg:my-8" />
            <div class="flex justify-between">
                <div>
                    <span class="block text-sm sm:text-center text-gray-400 font-light sm:text-md">© {{currentYear}} SportCity™ All Rights Reserved.</span>
                </div>
                <div class="block text-sm sm:text-center text-gray-400 font-light sm:text-md">
                    <a href="https://github.com/Yosiak-alv" target='_blank' rel='noopener noreferrer' class="hover:underline">@Josias-Alv</a>
                </div>
            </div>
        </div>
    </footer>
</template>

<style>
    .social-icon {
    display: inline-block;
    margin-left: 14px;
}
.social-icon a {
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
.social-icon a::before {
    content: "";
    width: 42px;
    height: 42px;
    position: absolute;
    background-color: #ffffff;
    border-radius: 50%;
    transform: scale(0);
	transition: 0.3s ease-in-out;
}
.social-icon a:hover::before {
    transform: scale(1);
}
.social-icon a img {
	width: 40%;
	z-index: 1;
	transition: 0.3s ease-in-out;
}
.social-icon a:hover img {
	filter: brightness(0) saturate(100%) invert(0%) sepia(7%) saturate(98%) hue-rotate(346deg) brightness(95%) contrast(86%);
}
</style>