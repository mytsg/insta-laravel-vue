<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';

const props = defineProps({
    'user': Object,
})

const status = ref(false)

const isFollowing = async(userId) => {
    await axios.get(`/follow/${userId}/check`)
    .then( res => {
        console.log('res.data',res.data)
        if(res.data == 1) {
            console.log('true')
            status.value = true
        } else {
            console.log('false')
            status.value = false
        }
    }).catch((e) => {
        console.log(e)
    })
}

isFollowing(props.user.id)

const follow = async(id) => {
    await axios.post(`/follow/${id}`)
    .then( res => {
    }).catch((e) => {
        console.log(e)
    })
    isFollowing(id)
}

onMounted(() => {

})
</script>

<template>
    <Head title="購買履歴 詳細画面" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ props.user.name }}のプロフィール
            </h2>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row mt-10">
                    <div class="w-1/3 text-center ">
                        <div v-if="props.user.icon" class="sm:w-48 sm:h-48 inline-flex items-center justify-center flex-shrink-0">
                            <img class="mt-8 rounded-full" :src="'/storage/icons/' + props.user.icon" alt="">
                        </div>
                        <div v-else class="sm:w-40 sm:h-40 sm:mr-10 inline-flex items-center justify-center rounded-full flex-shrink-0">
                            <img class="mt-8 rounded-full" :src="'images/no_image.png'" alt="">
                        </div>
                    </div>
                    <div class="w-2/3 sm:pl-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                        <div class="flex mb-4">
                            <h1 class="font-bold title-font text-2xl">{{ props.user.name }}</h1>
                            <button v-if="status" @click.prevent="follow(props.user.id)" class="w-1/8 text-xl ml-16 inline-block text-white bg-gray-300 hover:bg-gray-400 rounded px-8 py-2">フォロー中</button>
                            <button v-else @click.prevent="follow(props.user.id)" class="w-1/8 text-xl ml-16 inline-block text-white bg-blue-300 hover:bg-blue-400 rounded px-8 py-2">フォロー</button>
                        </div>
                        <div class="flex justify-start mb-4">
                            <h1 class="title-font font-bold text-xl">投稿○○件</h1>
                            <h1 class="title-font font-bold text-xl ml-16">フォロワー○○人</h1>
                            <h1 class="title-font font-bold text-xl ml-16">フォロー○○人</h1>
                        </div>
                        <h1 class="title-font font-bold text-2xl pb-4">{{ props.user.userName }}</h1>
                        <p class="leading-relaxed text-lg mb-4">{{ props.user.profile }}</p>
                        <a class="text-indigo-500 inline-flex items-center">Learn More
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>