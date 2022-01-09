<template>
    <div class="flex flex-col m-auto">
        <!-- error message  -->
        <div class="m-auto my-10 text-red-700">{{ errorText }}</div>
        <!-- error message -->

        <!-- content  -->
        <div class="flex" :class="{'opacity-50': loading}">
            <div class="flex flex-col items-center justify-center">
                <div class="m-1">Strlength:</div>
                <select class="mt-3 w-16 p-2" v-model="passwordStrlength">
                    <option :key="key" v-for="(item, key) in [1, 2, 3]" :value="item">{{ item}}</option>
                </select>
            </div>

            <div class="flex flex-col items-center justify-center">
                <div class="m-1">Length:</div>
                <select class="mt-3 w-16 p-2" v-model="passwordLength">
                    <option :key="key" v-for="(item, key) in lengthArray" :value="item">{{ item }}</option>
                </select>
            </div>
            <div class="flex items-end ml-3">
                <div @click="generate" :class="[!buttonStatus || loading?'opacity-25 cursor-auto':'cursor-pointer']" class="px-10 py-2 bg-green-400 flex justify-center items-center rounded">Generate</div>
            </div>
        </div>
        <!-- content  -->


        <!-- result  -->
        <div class="m-auto my-10 text-green-700 font-bold text-xl">
            <div class="absolute">{{ password }}</div>
        </div>
        <!-- result -->
    </div>
</template>


<script>
import { ref, computed } from 'vue'

export default {
    name: 'generator',
    setup(){

        const startIndexForStrlength = 6;
        const maxLength = 50;
        const passwordStrlength = ref(1)
        const passwordLength = ref(startIndexForStrlength)

        const buttonStatus = computed(() => {
            return [1, 2, 3].includes(Number(passwordStrlength.value)) && Number(passwordLength.value) >= 6 && Number(passwordLength.value) <= maxLength
        })

        const loading = ref(false);
        const password = ref('');
        const errorText = ref('')

        return {
            passwordStrlength,
            passwordLength,
            buttonStatus,
            loading,
            errorText,
            password,
            lengthArray: [...Array(maxLength + 1).keys()].splice(startIndexForStrlength),
            generate(){
                errorText.value = ''
                password.value = ''
                if(loading.value)return
                loading.value = true
                axios.get(`/api/generate/${passwordStrlength.value}/${passwordLength.value}`).then(response => {
                    if(response.data.hasOwnProperty('password')){
                        password.value = response.data.password
                    }
                }).catch(_ => {
                    errorText.value = 'error!!!'
                }).then(() => {
                    loading.value = false
                })
            }
        }
    },
}
</script>
