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
                <FormItem label="角色名：" prop="role">
                    <Input v-model="formData.role" type="text" placeholder="请输入角色名" style="width: 80%;"></Input>
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
                    role:''
                },
                formInline:{
                    role: [
                        { required: true, message: '请输入角色名', trigger: 'blur'},
                    ]
                },
                show : false,
                loading: true,
            };
        },
        props: {
            addModel: false
        },
        created (){
        },
        methods: {
            ok (name) {
                // 请求接口
                this.$refs[name].validate((valid) => {
                    if(valid){
                        this.JAjax.postJson('role/add', this.formData, res=>{
                            if ( res.code === 1){
                                this.$Message.success(res.message);
                                this.formData.role ='';
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
                this.show = true
            }
        }
    };
</script>
