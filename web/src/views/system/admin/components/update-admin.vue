<style lang="less">

</style>

<template>
    <div>
        <Modal
                v-model="show"
                title="新增管理员"
                @on-ok="ok('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100"  :rules="formInline" ref="formData">
                <FormItem label="姓名：" prop="name">
                    <Input v-model="formData.name" :disabled="formData.name === 'admin'" type="text" placeholder="请输入姓名" style="width: 80%;"></Input>
                </FormItem>
                <FormItem label="手机：" prop="phone">
                    <Input v-model="formData.phone" type="text" placeholder="请输入手机" style="width: 80%;"></Input>
                </FormItem>
                <FormItem label="权限：" prop="role">
                    <Select v-model="formData.role" placeholder="请选则权限角色"  style="width: 80%;" >
                        <Option v-for="role in roles" v-model="role.id.toString()" :key="role.role" >{{ role.role }}</Option>
                    </Select>
                </FormItem>
                <FormItem label="职务：" prop="job">
                    <CheckboxGroup v-model="formData.job" placeholder="请选则职务"  style="width: 80%;" >
                        <Checkbox label="is_manager">分管经理</Checkbox>
                        <Checkbox label="is_responsible">项目负责人</Checkbox>
                    </CheckboxGroup>
                </FormItem>
            </Form>
        </Modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    name: '',
                    phone:'',
                    role:'',
                    job:[]
                },
                formInline:{
                    name:[
                        { required: true, message: '请输入用户名', trigger: 'blur' },
                        { type: 'string', max: 20, message:'用户名字数不能多于20位数', trigger: 'blur' },
                    ],
                    phone:[
                        { required: true, message: '请确认手机号码', trigger: 'blur'},
                        { pattern: /^1[34578][0-9]{9}$/, message:'手机号码格式不正确', trigger: 'blur' },
                    ],
                    role: [
                        { required: true, message: '请选择权限角色', trigger: 'change'},
                    ]
                },
                show : false,
                roles: [],
                loading: true,
            };
        },
        props: {
            updateModal: false,
            data:{}
        },
        created (){
            this.getRoles();
        },
        methods: {
            // 获取权限角色
            getRoles () {
                this.JAjax.postJson('role/list', {}, (res) => {
                    this.roles = res.data;
                });
            },
            ok (name) {
                // 请求接口
                this.$refs[name].validate((valid) => {
                    if(valid){
                        this.JAjax.postJson('admin/update/'+this.data.id, this.formData, res=>{
                            if ( res.code === 1){
                                this.$Message.success(res.message);
                                this.formData.name ='';
                                this.formData.phone ='';
                                this.formData.role ='';
                                this.formData.job = [];
                                this.$emit('afresh_list', 'data')
                            }
                        })
                        setTimeout(() => {
                            this.show = false;
                        }, 500);
                    }else{
                        this.loading = false;
                        setTimeout(() => {
                            this.loading = true;
                        }, 100);
                        this.$Message.error('请检查您输入的信息');
                    }
                })
            },
            cancel () {
                // this.$Message.info('Clicked cancel');
            }
        },
        watch: {
            updateModal () {
                this.show = true
                this.formData = {
                        name: this.data.name,
                        phone:this.data.phone,
                        role: this.data.role_id === null ? '' : this.data.role_id.toString() ,
                        job:[]
                }
                if(this.data.is_manager){
                    this.$set(this.formData.job,0,'is_manager')
                }
                if(this.data.is_responsible){
                    this.$set(this.formData.job,1,'is_responsible')
                }
            }
        }
    };
</script>
