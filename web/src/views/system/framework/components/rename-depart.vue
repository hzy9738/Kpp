<style lang="less">

</style>

<template>
    <div>
        <Modal
                v-model="show"
                title="修改"
                @on-ok="ok('formData')"
                @on-cancel="cancel">
            <Form  :label-width="100">
                <Form :model="formData" :label-width="100"  :rules="formInline" ref="formData">
                    <FormItem label="分支：" prop="page">
                        <Input v-model="formData.page" type="text" placeholder="请输入分支名称" style="width: 80%"></Input>
                    </FormItem>
                    <FormItem label="路由：" prop="route">
                        <Input v-model="formData.route" type="text" placeholder="请输入路由" style="width: 80%"></Input>
                    </FormItem>
                </Form>
            </Form>
        </Modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    page: '',
                    route: ''
                },
                formInline:{
                    page:[
                        { required: true, message: '请输入分支名', trigger: 'blur' },
                    ],
                    route:[
                        { required: true, message: '请输入路由', trigger: 'blur'},
                        { pattern: /^[A-Za-z]+$/, message:'路由必须是纯英文', trigger: 'blur' },
                    ],
                },
                show : false,
                loading: true
            };
        },
        props: {
            renameModel: false,
            depart_id: 0,
            ident:0,
            route:'',
            name : ''
        },
        methods: {
            ok (name) {
                // 请求接口
                this.$refs[name].validate((valid) => {
                    if(valid){
                        this.formData.ident  = this.ident
                        this.formData.id  = this.depart_id
                        if(this.formData.ident === 2){
                            this.formData.child_page  = this.formData.page
                            this.formData.child_route  = this.formData.route
                        }else if(this.formData.ident === 3){
                            this.formData.title  = this.formData.page
                            this.formData.use_route  = this.formData.route
                        }
                        this.JAjax.postJson('framework/update', this.formData, res=>{
                            if ( res.code === 1){
                                this.$Message.success(res.message);
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
            renameModel () {
                this.show = true
            },
            depart_id () {
                this.formData.page  = this.name
                this.formData.route  = this.route
                this.depart_id = this.depart_id
                this.ident = this.ident
            }
        }
    };
</script>
