<style lang="less">
    @import "./home.less";
    @import "../../../styles/common.less";
</style>
<template>
    <div class="home-main">
        <Row :gutter="10">
            <Col span="24">
            <Card>
                <p slot="title">
                    <Icon type="cube"></Icon>
                    修改密码
                </p>
                <Row>
                    <Form :model="formData" :label-width="100"  :rules="formInline" ref="formData">
                        <FormItem label="旧密码：" prop="old_password">
                            <Input v-model="formData.old_password" type="password" placeholder="请输入旧密码"
                                   style="width: 500px;"></Input>
                        </FormItem>
                        <FormItem label="新密码：" prop="password">
                            <Input v-model="formData.password" type="password" placeholder="请输入新密码"
                                   style="width: 500px;"></Input>
                        </FormItem>
                        <FormItem label="确认新密码：" prop="password_confirm">
                            <Input v-model="formData.password_confirm" type="password" placeholder="确认新密码"
                                   style="width: 500px;"></Input>
                        </FormItem>
                        <FormItem label="">
                            <!--<Button  @click="goBack" style="width:100px;margin-right: 50px;">取消</Button>-->
                            <Button :loading="loading" style="width:100px;" type="primary"  @click="handleSubmit('formData')">
                                <span v-if="!loading">保存</span>
                                <span v-else>Loading...</span>
                            </Button>
                        </FormItem>
                    </Form>
                </Row>
            </Card>
            </Col>
        </Row>
    </div>
</template>

<script>
    import Cookie from 'js-cookie'
    export default {
        name: 'update-password',
        components: {
        },
        data () {
            var validateConfrim = (rule, value, callback) => {
                if (value !== this.formData.password) {
                    callback(new Error('两次输入密码不一致!'));
                } else {
                    callback();
                }
            };
            return {
                formData: {
                    old_password:'',
                    password:'',
                    password_confirm: '',
                },
                formInline:{
                    old_password:[
                        { required: true, message: '请输入旧密码', trigger: 'blur' },
                    ],
                    password:[
                        { required: true, message: '请输入新密码', trigger: 'blur'},
                        { type: 'string', min: 6, message:'新密码字数不能少于6位数', trigger: 'blur' },
                        { pattern: /[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/, message:'新密码必须包含字母和数字', trigger: 'blur' },
                    ],
                    password_confirm:[
                        { required: true, message: '请确认新密码', trigger: 'blur'},
                        { validator: validateConfrim, trigger: 'blur'},
                    ]
                },
                loading:false,
            };
        },
        computed: {
            avatorPath () {
                return localStorage.avatorImgPath;
            }
        },
        methods: {
            handleSubmit (name) {
                // 请求接口
                this.$refs[name].validate((valid) => {
                    if(valid){
                        if(this.loading){
                            return false;
                        }else{
                            this.loading = true;
                        }
                        let id = Cookie.get('user_id');
                        if(!id){
                            this.$Message.error('无法修改，请重新登录');
                        }
                        //请求接口
                        this.JAjax.postJson('password/update/'+id, this.formData, (res) => {
                            this.$Message.success(res.message);
                        });
                        setTimeout(() => {
                            this.loading = false;
                        }, 500);

                    }else{
                        this.$Message.error('请检查您输入的信息');
                    }
                })
            },
        }
    };
</script>
