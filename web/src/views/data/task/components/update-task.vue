<style lang="less">
    @import './../components/table.less';
</style>

<template>
    <div>
        <Modal
                v-model="show"
                title="管理项目"
                @on-ok="ok('formData')"
                :loading="loading"
                :width="900"
                :styles="{top: '20px'}">
            <Form :model="formData" :label-width="100"  :rules="formInline" ref="formData">
                <div>
                    <p class="title">项目信息</p>
                    <FormItem label="项目名称：" prop="task">
                        <Input v-model="formData.task" type="text" placeholder="请输入项目名称" style="width: 91%"></Input>
                    </FormItem>
                    <FormItem label="分管经理：" prop="manager" style="display: inline-block;width: 46%">
                        <Select v-model="formData.manager">
                            <Option v-for="item in managers" :value="item.id" :key="item.id">{{ item.name }}</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="负责人：" prop="responsible" style="display: inline-block;width: 46%">
                        <Select v-model="formData.responsible">
                            <Option v-for="item in responsibles" :value="item.id" :key="item.id">{{ item.name }}</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="属性：" prop="attribute">
                        <RadioGroup v-model="formData.attribute">
                            <Radio label="0">项目</Radio>
                            <Radio label="1">部门（项目之外的分值均归属部门）</Radio>
                        </RadioGroup>
                    </FormItem>

                </div>
                <div>
                    <p class="title">参与成员（括号内为剩余的可用分值）</p>
                    <CheckboxGroup v-model="formData.staff">
                        <FormItem :label="depart.depart"  prop="staff" v-for="depart in staffs" v-if="depart.staffs.length">
                            <Checkbox
                                    :disabled="!staff.is_active || (formData.attribute === '1' && centerFixStaffs.indexOf(staff.id) !== -1)"
                                    v-for="staff in depart.staffs"
                                    v-if="formData.staff.indexOf(staff.id) !==  -1 || staff.is_active"
                                    :label="staff.id"
                                    style="width:170px">
                                 <span >{{ staff.staff }}</span>
                                <InputNumber
                                        :max="finMark[staff.id]"
                                        :min="0"
                                        v-model="formData.mark[staff.id]"
                                        :disabled="formData.staff.indexOf(staff.id) === -1 || !staff.is_active"
                                        size="small"
                                        placeholder="项目分值"
                                        style="width:65px">
                                </InputNumber>
                                <span style="color: #999999;">({{ staff.is_active ?  finMark[staff.id] : '离职' }})</span>
                                <!--<Input v-model="formData.mark[staff.id]"  size="small" placeholder="任务分值" style="width:65px"></Input>-->
                            </Checkbox>
                        </FormItem>
                    </CheckboxGroup>
                </div>
            </Form>
        </Modal>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    task: '',
                    manager: '',
                    responsible: '',
                    attribute: 0,
                    staff:[],
                    mark:[]
                },
                formInline:{
                    task:[
                        { required: true, message: '请输入项目名称', trigger: 'blur' },
                    ],
                    manager:[
                        { required: true, message: '请选择分管经理' },
                    ],
                    responsible:[
                        { required: true, message: '请选择负责人'},
                    ],

                },
                show : false,
                loading: true,
                finMark:[],
                centerFixStaffs:{}
            };
        },
        props: {
            updateModel: false,
            managers:{},
            responsibles:{},
            staffs:{},
            data:{},
            centerStaffs:{},
        },
        created () {
        },
        methods: {
            getDate (date) {
                this.formData.entry_at = date
            },
            ok (name) {
                // 请求接口
                let isZero = false
                this.formData.staff.forEach(t=>{
                    if(this.formData.mark[t] === 0){
                        isZero = true
                    }
                })
                // if(isZero){
                //     this.$Message.error('分值不可有0，请检查');
                //     setTimeout(() => {
                //         this.newModel= true,
                //             this.loading = false;
                //     }, 100);
                //     return
                // }
                this.$refs[name].validate((valid) => {
                    if(valid){
                        this.JAjax.postJson('task/update/'+this.data.id, this.formData, res=>{
                                this.$Message.success(res.message);
                                this.$emit('afresh_list', 'data')
                        })
                        setTimeout(() => {
                            this.show = false;
                            this.formData = {
                                task: '',
                                manager: '',
                                responsible: '',
                                attribute: '0',
                                staff:[],
                                mark:[]
                            }
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
                this.formData = {
                        task: this.data.task,
                        manager: this.data.managers.id,
                        responsible: this.data.responsibles.id,
                        attribute: String(this.data.attribute),
                        staff:[],
                        mark:[],
                }
                Object.values(this.staffs).forEach(t=>{
                    // console.log(t)
                    Object.values(t.staffs).forEach(e=>{
                        this.formData.mark[e.id] = 0
                        this.finMark[e.id] = e.maxMark
                    })
                })
                this.data.marks.forEach(t=>{
                    this.formData.staff.push(t.staff_id)
                    this.formData.mark[t.staff_id] = t.mark
                    this.finMark[t.staff_id] = this.finMark[t.staff_id] + t.mark
                })
                this.centerFixStaffs = [];
                this.centerStaffs.forEach(t=>{
                    if(this.formData.staff.indexOf(t) === -1){
                        this.centerFixStaffs.push(t)
                    }
                })
            }
        }
    };
</script>
