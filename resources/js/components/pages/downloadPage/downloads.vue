<template>
    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top">
        <FormItem label="Coastal Hazards Maps" class="w-full" prop="coastal">
            <Select v-model="formValidate.coastalHazardMapsValue" multiple style="width:100%" placeholder="Select Coastal Hazard Map">
                <Option v-for="item in hazardMapOptions" :value="item.value" :key="item.value">{{ item.label }}
                </Option>
            </Select>
        </FormItem>
        <FormItem label="Official Email" class="w-full" prop="officialEmail">
            <Input v-model="formValidate.officialEmail" placeholder="Enter Official Email"></Input>
        </FormItem>
        <FormItem label="Name" class="w-full" prop="name">
            <Input v-model="formValidate.name" placeholder="Enter Name"></Input>
        </FormItem>
        <FormItem label="Sex" class="w-full" prop="sex">
            <Select v-model="formValidate.sex" style="width:100%"
                placeholder="Sex">
                <Option v-for="item in sex" :value="item.value" :key="item.value">{{ item.label }}</Option>
            </Select>
        </FormItem>
        <FormItem label="Address" class="w-full" prop="address">
            <Input v-model="formValidate.address" placeholder="Enter Address"></Input>
        </FormItem>
        <FormItem label="Office/Agency" class="w-full" prop="officeAgency">
            <Input v-model="formValidate.officeAgency" placeholder="Enter Office/Agency"></Input>
        </FormItem>
        <FormItem label="Purpose" class="w-full" prop="purpose">
            <Input v-model="formValidate.purpose" type="textarea" placeholder="Enter Purpose"></Input>
        </FormItem>
        <FormItem label="Official Contact No. (+63)" class="w-full" prop="contactNo">
            <Input v-model="formValidate.contactNo" placeholder="Official Contact No."></Input>
        </FormItem>
        <div class="flex justify-end">
            <a-button key="submit" type="primary" @click="handleSubmit('formValidate')">Submit</a-button>
        </div>
    </Form>
</template>
<script>
    import { defineComponent, ref, watch } from 'vue';
    import { notification, message } from 'ant-design-vue';
    export default {
        setup() {
            const hazardMapOptions = ref([{
                value: '1',
                label: 'Coastal Flood Hazard Map',
            }, {
                value: '2',
                label: 'Coastal Flood Depth Map',
            }, {
                value: '3',
                label: 'Coastal Flood Hazard Map with Return Period',
            }, {
                value: '4',
                label: 'Coastal Flood Depth Map with Return Period',
            }]);

            const sex = ref([{
                value: '1',
                label: 'Male',
            }, {
                value: '2',
                label: 'Female',
            }]);


            const filterOption = (input, option) => {
                return option.value.toLowerCase().indexOf(input.toLowerCase()) >= 0;
            };

            return {
                hazardMapOptions,
                sex,
                filterOption,
            };
        },
        data() {
            return {
                formValidate: {
                    coastalHazardMapsValue: '',
                    coastal: '',
                    officialEmail: '',
                    name: '',
                    sex: '',
                    address: '',
                    officeAgency: '',
                    purpose: '',
                    contactNo: '',

                },
                ruleValidate: {
                    coastalHazardMapsValue: [
                        { required: true, message: 'The Coastal Hazards Maps cannot be empty', trigger: 'blur' }
                    ],
                    coastal: [
                        { required: true, message: 'The Coastal Hazards Maps cannot be empty', trigger: 'blur' }
                    ],
                    officialEmail: [
                        { required: true, message: 'The Official Email cannot be empty', trigger: 'blur' },
                        { type: 'email', message: 'Incorrect email format', trigger: 'blur' }
                    ],
                    name: [
                        { required: true, message: 'The Official Email cannot be empty', trigger: 'blur' }
                    ],
                    sex: [
                        { required: true, message: 'The Sex cannot be empty', trigger: 'blur' }
                    ],
                    address: [
                        { required: true, message: 'The Address cannot be empty', trigger: 'blur' }
                    ],
                    officeAgency: [
                        { required: true, message: 'The Office/Agency cannot be empty', trigger: 'blur' }
                    ],
                    purpose: [
                        { required: true, message: 'The Purpose cannot be empty', trigger: 'blur' }
                    ],
                    contactNo: [
                        { required: true, message: 'The Official Contact No. cannot be empty', trigger: 'blur' }
                    ],
                }
            }
        },
        methods: {
            sendIdToParent() {
                // Emit an event with the id as payload
                let existingObj = this;
                this.$emit('id-selected', false); // Replace someId with the actual data you want to send
                this.formValidate.coastalHazardMapsValue = ''
                this.formValidate.coastal = ''
                this.formValidate.officialEmail = ''
                this.formValidate.name = ''
                this.formValidate.sex = ''
                this.formValidate.address = ''
                this.formValidate.officeAgency = ''
                this.formValidate.purpose = ''
                this.formValidate.contactNo = ''
            },
            async handleSubmit(name) {
                let existingObj = this;
                if(existingObj.formValidate.coastalHazardMapsValue.length != 0){
                    existingObj.formValidate.coastal = 'Something'
                }else{
                    existingObj.formValidate.coastal = ''
                }
                await this.$refs[name].validate((valid) => {
                    if (valid) {
                            axios.post(`/api/storeDownload`, this.formValidate)
                                .then(function (response) {
                                    message.success('Success! Please check you email');
                                    existingObj.sendIdToParent();
                                })
                                .catch(function (error) {
                                });
                    } else {
                        
                    }
                })
               
            }
        }
    }
</script>