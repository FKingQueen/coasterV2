<template>
    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top">
        <FormItem label="Data Request" class="w-full">
            <!-- <FormItem class="w-full"> -->
            <Input disabled v-model="dataName" />
        </FormItem>
        <FormItem label="Official Email" class="w-full" prop="email">
            <Input v-model="formValidate.email" placeholder="Enter Official Email"></Input>
        </FormItem>
        <FormItem label="Name" class="w-full" prop="name">
            <Input v-model="formValidate.name" placeholder="Enter Name"></Input>
        </FormItem>
        <FormItem label="Address" class="w-full" prop="address">
            <Input v-model="formValidate.address" placeholder="Enter Address"></Input>
        </FormItem>
        <FormItem label="Office/Agency" class="w-full" prop="agency">
            <Input v-model="formValidate.agency" placeholder="Enter Office/Agency"></Input>
        </FormItem>
        <FormItem label="Purpose" class="w-full" prop="purpose">
            <Input v-model="formValidate.purpose" type="textarea" placeholder="Enter Purpose"></Input>
        </FormItem>
        <div class="flex justify-end">
            <a-button key="submit" type="primary" @click="handleSubmit('formValidate')">Submit</a-button>
        </div>
    </Form>
</template>
<script>
import { defineComponent, ref, watch, nextTick } from 'vue';
import { notification, message } from 'ant-design-vue';
export default {
    props: ['id'],
    watch: {
        id(newValue, oldValue) {
            // This function will be called when myProp changes
            let thiss = this;
            if (thiss.id == 1) {
                thiss.dataName = 'Ilocos Norte Water Level Monitoring System Data'
            }
            if (thiss.id == 2) {
                thiss.dataName = 'Ilocos Sur Water Level Monitoring System Data'
            }
            if (thiss.id == 3) {
                thiss.dataName = 'Ilocos Norte Buoy Monitoring System Data'
            }
            if (thiss.id == 4) {
                thiss.dataName = 'Ilocos Sur Buoy Monitoring System Data'
            }
            console.log(thiss.dataName);
        }
    },
    data() {
        return {
            formValidate: {
                email: '',
                name: '',
                address: '',
                agency: '',
                purpose: '',
            },
            dataName: '',
            ruleValidate: {
                email: [
                    { required: true, message: 'The Official Email cannot be empty', trigger: 'blur' },
                    { type: 'email', message: 'Incorrect email format', trigger: 'blur' }
                ],
                name: [
                    { required: true, message: 'The Name cannot be empty', trigger: 'blur' }
                ],
                address: [
                    { required: true, message: 'The Address cannot be empty', trigger: 'blur' }
                ],
                agency: [
                    { required: true, message: 'The Office/Agency cannot be empty', trigger: 'blur' }
                ],
                purpose: [
                    { required: true, message: 'The Purpose cannot be empty', trigger: 'blur' }
                ],
            }
        }
    },
    methods: {
        async handleSubmit(name) {
            let thiss = this;
            await this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/storeDownload`, thiss.formValidate)
                        .then(function (response) {
                            console.log(response);
                            message.success('Success! We will send you the data as soon as possible Thank you!');
                        })
                        .catch(function (error) {
                        });
                } else {

                }
            })
        }
    },
    mounted() {
        // Use nextTick to ensure the DOM has been updated
    }
}
</script>