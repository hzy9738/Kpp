<style lang="less">

</style>

<template>
    <div>
        <Modal
                v-model="show"
                title="添加新员工"
                @on-ok="ok('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100"  :rules="formInline" ref="formData">
                <FormItem label="员工姓名：" prop="staff">
                    <Input v-model="formData.staff" type="text" placeholder="请输入员工姓名" style="width: 80%"></Input>
                </FormItem>
                <FormItem label="所属部门：" prop="depart">
                    <Cascader :data="departs" v-model="formData.depart" change-on-select placeholder="请输入所属部门" style="width: 80%"></Cascader>
                </FormItem>
                <FormItem label="所属岗位：" prop="position">
                    <Input v-model="formData.position" type="text" placeholder="请输入所属岗位" style="width: 80%"></Input>
                </FormItem>
                <FormItem label="入职时间：" prop="entry_at">
                    <DatePicker @on-change="getDate" v-model="date" type="date" placeholder="请输入入职时间" format="yyyy-MM-dd" style="width: 80%"></DatePicker>
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
                    staff: '',
                    depart: [],
                    position: '',
                    entry_at: '',
                },
                formInline:{
                    staff:[
                        { required: true, message: '请输入员工姓名', trigger: 'blur' },
                    ],
                    depart:[
                        { required: true, message: '请输入所属部门'},
                    ],
                    position:[
                        { required: true, message: '请输入所属岗位', trigger: 'blur'},
                    ],
                    entry_at:[
                        { required: true, message: '请输入入职时间'},
                    ],
                },
                show : false,
                loading: true,
                departs:[],
                date:''
            };
        },
        props: {
            updateModel: false,
            data:{}
        },
        created () {
            this.getDeparts()
        },
        methods: {
            getDate (date) {
                this.formData.entry_at = date
            },
            getDeparts () {
                this.JAjax.postJson('depart/tree-list', this.formData, res=> {
                    this.departs = res.data || {}
                })
            },
            ok (name) {
                // 请求接口
                this.$refs[name].validate((valid) => {
                    if(valid){
                        this.JAjax.postJson('staff/update/'+ this.data.id, this.formData, res=>{
                                this.$Message.success(res.message);
                                this.formData = {
                                        staff: '',
                                        depart: '',
                                        position: '',
                                        entry_at: '',
                                }
                                this.$emit('afresh_list', 'data')
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
            updateModel () {
                this.show = true
                this.data = this.data
                this.formData = {
                        staff: this.data.staff,
                        depart: this.data.departs.map(item=>item.id.toString()),
                        position: this.data.position.toString(),
                        entry_at: this.data.entry_at,
                }
                this.date = this.data.entry_at
                // console.log(this.formData.depart)
            }
        }
    };
</script>
