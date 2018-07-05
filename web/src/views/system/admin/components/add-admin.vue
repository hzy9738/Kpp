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
                    <Input v-model="formData.name" type="text" placeholder="请输入姓名" style="width: 80%;"></Input>
                </FormItem>
                <FormItem label="手机：" prop="phone">
                    <Input v-model="formData.phone" type="text" placeholder="请输入手机" style="width: 80%;"></Input>
                </FormItem>
                <FormItem label="密码：" prop="password">
                    <Input v-model="formData.password" type="text" placeholder="请输入密码" style="width: 80%;"></Input>
                </FormItem>
                <FormItem label="权限：" prop="role">
                    <Select v-model="formData.role" placeholder="请选则权限角色"  style="width: 80%;" >
                        <Option v-for="role in roles" :value="role.id.toString()" :key="role.role" >{{ role.role }}</Option>
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
                    password:'',
                    role:'',
                    job:[]
                },
                formInline:{
                    name:[
                        { required: true, message: '请输入用户名', trigger: 'blur' },
                        { type: 'string', max: 20, message:'用户名字数不能多于20位数', trigger: 'blur' },
                    ],
                    password:[
                        { required: true, message: '请输入新密码', trigger: 'blur'},
                        { type: 'string', min: 6, message:'密码字数不能少于6位数', trigger: 'blur' },
                        { pattern: /[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/, message:'密码必须包含字母和数字', trigger: 'blur' },
                    ],
                    phone:[
                        { required: true, message: '请确认手机号码', trigger: 'blur'},
                        { pattern: /^1[34578][0-9]{9}$/, message:'手机号码格式不正确', trigger: 'blur' },
                    ],
                    role: [
                        { required: true, message: '请选择权限角色', trigger: 'change'},
                    ],
                    job: []
                },
                show : false,
                roles: [],
                loading: true,
            };
        },
        props: {
            addModel: false
        },
        created (){

        },
        methods: {
            // 获取权限角色
            getRoles () {
                this.JAjax.postJson('role/list', {}, (res) => {
                    this.roles = res.data;
                });
            },
            // // 获取部门
            // getDeparts () {
            //     this.JAjax.postJson('depart/tree-list', {}, (res) => {
            //         this.departs = res.data;
            //     });
            // },
            ok (name) {
                // 请求接口
                this.$refs[name].validate((valid) => {
                    if(valid){
                        this.JAjax.postJson('admin/add', this.formData, res=>{
                            if ( res.code === 1){
                                this.$Message.success(res.message);
                                this.formData.name ='';
                                this.formData.phone ='';
                                this.formData.password ='';
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
            addModel () {
                this.show = true;
                this.getRoles();
            }
        }
    };
</script>
