<style lang="less">
    @import "../../../styles/common.less";
    @import './components/table.less';
</style>
<template>
    <div class="home-main">
        <Row :gutter="10">
            <Col span="24">
            <Card>
                <p slot="title">
                    <Icon type="cube"></Icon>
                    项目录入修改
                </p>
                <DatePicker type="month"
                            placeholder="选择时间"
                            v-model="date"
                            @on-change="getNoteTasks"
                            style="position: absolute;top: 10px;left:150px;width: 150px">
                </DatePicker>
                <Select v-model="taskId"
                        placeholder="选择项目"
                        @on-change="getTask"
                        style="position: absolute;top: 10px;left:340px;width: 150px">
                    <Option value="0" key="0" v-if="tasks.length === 0">无项目待提交</Option>
                    <Option v-for="item in tasks" :value="item.id" :key="item.id" v-if="tasks.length !== 0">{{ item.task
                        }}
                    </Option>
                </Select>
                <Row>
                    <Row v-if="staffs.length === 0">
                        <div style="margin-bottom: 40px;color: #999999">请先确定时间，并选择项目</div>
                        <div>
                            <Button @click="goBack" style="width:100px;margin-right: 50px;">返回</Button>
                        </div>
                    </Row>
                    <Form :model="formData" ref="formData" v-if="staffs.length !== 0">
                        <Row class="title" :gutter="16">{{ task.task }} 项目成员绩效</Row>
                        <Row v-for="(staff,index) in staffs" class="staff" :class="active[index] ? 'active':''">
                            <div @click="clickStaff(index)">
                                <Col span="6">
                                {{ staff.staff}}（{{ staff.position}}）</Col>
                                <Col span="6">
                                <RadioGroup v-model="formData.isMark[staff.id]">
                                    <Radio label='0'>本月不考核</Radio>
                                    <Radio label='1'>考核得分</Radio>
                                </RadioGroup>
                                </Col>
                                <Col span="6">
                                <InputNumber
                                        :max="100" :min="1"
                                        style="width:100px"
                                        @on-change="getMarkRange(staff.id,formData.mark[staff.id])"
                                        :disabled="formData.isMark[staff.id] !== '1'"
                                        v-model="formData.mark[staff.id]">
                                </InputNumber>
                                <div style="display: inline-block;width: 100px;">
                                    <span v-if="formData.isMark[staff.id] === '1'" :class="formData.active[staff.id]">{{ formData.appraise[staff.id] }}</span>
                                </div>
                                </Col>
                                <Col span="6">
                                <!--( 绩效权重{{ staff.pivot.mark ? (  staff.pivot.mark ).toFixed()+'%': '0' }} )-->
                                    <span v-if="!attribute">  ( 绩效权重{{ staff.pivot.mark !== null ? (staff.pivot.mark / finMark[staff.id] *100).toFixed(1)+'%': '0' }} )</span>
                                    <span v-if="attribute">  ( 绩效权重{{ staff.pivot.mark !== null? ((staff.pivot.mark + (isNotMark[staff.id] ? isNotMark[staff.id] : 0 )) / finMark[staff.id] *100).toFixed(1)+'%': '0' }} )</span>

                                </Col>
                            </div>
                        </Row>

                        <Col span="6" :gutter="16" style="margin-top: 30px">
                        <Button @click="goBack" style="width:100px;margin-right: 50px;">返回</Button>
                        <Button :loading="loading" style="width:100px;" type="primary"
                                @click="handleSubmit('formData')">
                            <span v-if="!loading">提交</span>
                            <span v-else>Loading...</span>
                        </Button>
                        </Col>
                    </Form>
                </Row>
            </Card>
            </Col>
        </Row>
        <Modal v-model="warningModal" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="information-circled"></Icon>
                <span>提示</span>
            </p>
            <div style="text-align:center">
                <p style="text-align: left">请注意:</p>
                <p>各项目/中心每月考评结果为D级或E级的员工占考核总数的15%。</p>
            </div>
            <div slot="footer">
                <Button type="success" @click="warnBack">返回修改</Button>
                <Button @click="warnGo">确定，继续提交</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData: {
                    mark: [],
                    isMark: [],
                    staffId: [],
                    appraise: [],
                    introduce: [],
                    active: [],
                    oldMark:[],
                },
                markRange: [
                    {
                        'min': 96, 'max': 100, 'appraise': '优秀', 'introduce': 'A', 'active': 'activeSuccess'
                    },
                    {
                        'min': 90, 'max': 95.9, 'appraise': '优良', 'introduce': 'B', 'active': ''
                    },
                    {
                        'min': 80, 'max': 89.9, 'appraise': '合格', 'introduce': 'C', 'active': ''
                    },
                    {
                        'min': 60, 'max': 79.9, 'appraise': '不足', 'introduce': 'D', 'active': ''
                    },
                    {
                        'min': 1, 'max': 59.9, 'appraise': '不合格', 'introduce': 'E', 'active': 'activeError'
                    }
                ],
                loading: false,
                active: [],
                staffs: [],
                tasks: [],
                noteTasks: [],
                finMark: [],
                isNotMark:[],
                taskId: '',
                task: {},
                date: '',
                attribute: 0,
                warningModal: false
            };

        },
        methods: {
            warnBack () {
                this.warningModal = false;
            },
            warnGo () {
                this.submitCallback();
            },
            submitCallback () {
                if (this.loading) {
                    return false;
                } else {
                    this.loading = true;
                }
                this.formData.date = this.toMonth(this.date);
                this.formData.task_id = this.task.id;
                this.JAjax.postJson('note/month/task/update', this.formData, res => {
                    this.$Message.success(res.message);
                    this.loading = false;
                    this.$router.push({
                        name: 'note-month',
                    });
                });
                this.loading = false;
            },
            getNoteTasks (date) {
                this.date = date;
                if (date == this.$route.query.date) {
                    return false;
                }
                this.staffs = [];
                this.tasks = [];
                this.formData = {
                    mark: [],
                    isMark: [],
                    staffId: [],
                    appraise: [],
                    introduce: [],
                    active: [],
                };
                this.$router.push({
                    name: 'update_task',
                    query: {
                        'date': date
                    }
                });
                this.init();

            },
            getMarkRange (id, mark) {
                this.markRange.forEach(t => {
                    if (mark >= t.min && mark <= t.max) {
                        this.formData.appraise[id] = t.appraise;
                        this.formData.introduce[id] = t.introduce;
                        this.formData.active[id] = t.active;
                    }
                });
            },
            clickStaff (index) {
                this.active = [];
                this.$set(this.active, index, true);
            },
            handleSubmit (name) {
                if (this.date === '') {
                    this.$Message.error('请先选择时间');
                    return false;
                }

                if (this.formData.staffId.length !== 0) {
                    let isNotIsMark = false
                    this.formData.staffId.forEach(i => {
                        if (this.formData.isMark[i] === undefined) {
                            isNotIsMark = true
                        }
                    });
                    if (isNotIsMark) {
                        this.$Message.error('请确认无尚未勾选的选项');
                        return false;
                    }
                    let staffLength = this.formData.staffId.length;
                    if (staffLength * 0.15 >= 0.5) {
                        let warnStaff = [];
                        this.formData.staffId.forEach(t => {
                            if (this.formData.isMark[t] && this.formData.mark[t] < 80) {
                                warnStaff.push(t);
                            }
                        });
                        if (warnStaff.length < staffLength * 0.15) {
                            this.warningModal = true;
                            console.log(warnStaff.length + '--' + staffLength + '---' + '    1');
                        } else {
                            console.log(warnStaff.length + '--' + staffLength + '---' + '    2');
                            this.submitCallback();
                        }
                    } else {
                        // console.log(warnStaff.length + '3')
                        this.submitCallback();
                    }
                } else {
                    this.$Message.error('无法提交');
                }
            },
            goBack () {
                this.$router.push({
                    name: 'note-month',
                });
            },
            // 获取项目
            getTasks () {
                this.JAjax.postJson('task/update/list', {date: this.toMonth(this.date)}, res => {
                    this.tasks = res.data || [];
                    this.finMark = res.finMark || [];
                    this.isNotMark = res.isNotMark || [];
                });
            },
            // 获取项目和项目员工
            getTask () {
                if (this.date === '') {
                    this.$Message.error('请先选择时间');
                    return;
                }
                this.formData.appraise = [];
                this.formData.isMark = [];
                this.formData.oldMark = [];
                this.tasks.forEach(t => {
                    // this.attribute = t.attribute

                    if (t.id === this.taskId) {

                        this.attribute = t.attribute;
                        this.task = t;
                        this.staffs = [];
                        this.formData.staffId = [];
                        let preMonth = Date.parse(this.toMonth(this.date));
                        t.staffs.forEach((e) => {
                            if (e.leave_at === null) {
                                this.staffs.push(e);
                                this.formData.staffId.push(e.id);
                            } else if (Date.parse(this.toMonth(e.leave_at)) >= preMonth) {
                                // this.formData.isMark[e.id] = '0'
                                // this.formData.mark[e.id] = 0
                                // this.getMarkRange(e.id,0)
                                this.staffs.push(e);
                                this.formData.staffId.push(e.id);
                            }
                            // console.log(e)
                            this.$set(this.formData.mark, e.id, 1);
                            if(e.pivot.mark !== null){
                                this.$set(this.formData.oldMark, e.id, e.pivot.mark);
                            }
                            // this.$set(this.formData.isMark,e.id,'0')
                        });
                        t.note_staffs.forEach(e => {
                            this.getMarkRange(e.pivot.staff_id, e.pivot.mark);
                             if(e.pivot.is_mark){
                                 this.$set(this.formData.mark, e.pivot.staff_id, Number(e.pivot.mark));
                             }else{
                                 this.$set(this.formData.mark, e.pivot.staff_id, 1);
                             }
                            this.$set(this.formData.isMark, e.pivot.staff_id, String(e.pivot.is_mark));
                        });
                        // console.log(this.staffs)
                    }
                });
            },
            // 获取前一个月
            getPreMonth (date) {
                var arr = date.split('-');
                var year = arr[0]; //获取当前日期的年份
                var month = arr[1]; //获取当前日期的月份
                var year2 = year;
                var month2 = parseInt(month) - 1;
                if (month2 == 0) {
                    year2 = parseInt(year2) - 1;
                    month2 = 12;
                }
                if (month2 < 10) {
                    month2 = '0' + month2;
                }
                var t2 = year2 + '-' + month2;
                return t2;
            },
            init () {
                this.date = this.$route.query.date;
                this.getTasks();
            }
        },
        mounted () {
            this.init();
        }
    };
</script>
