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
                    月度绩效统计表 ( {{ date }} )
                    <span class="cube"></span>

                </p>
                <Button @click="routeType" style="top: 10px;position: absolute;left: 250px" class="button"
                        :type="type ? 'ghost' : 'primary'" shape="circle">按项目查看
                </Button>
                <Button @click="routeType" style="top: 10px;position: absolute;left: 350px" class="button"
                        :type="type ? 'primary' : 'ghost'" shape="circle">按员工查看
                </Button>

                <Dropdown  style="top: 10px;position: absolute;left: 600px" @on-click="excelNoteMark">
                    <Button type="success">
                        导出Excel
                        <Icon type="arrow-down-b"></Icon>
                    </Button>
                    <DropdownMenu slot="list" >
                        <DropdownItem name="mark">考核分数表</DropdownItem>
                        <DropdownItem name="staff">组织关系表</DropdownItem>
                    </DropdownMenu>
                </Dropdown>

                <Button style="float: right;margin-left: 10px;" size="small" @click="selectStaff">搜索</Button>

                <Input v-model="staffSearch" size="small" placeholder="搜索员工"
                       style="width: 120px;float: right;margin-left:20px"></Input>

                <Select v-model="depart" @on-change="selectDepart" size="small" style="width:100px;float: right">
                    <Option value="-1">全部部门</Option>
                    <Option v-for="item in departStaffs" :value="item.id" :key="item.id">{{ item.depart }}</Option>
                </Select>


                <div style="margin-bottom: 20px">
                    <Button :type="active === -1 ? 'info' : 'ghost'" size="small" @click="rangeClick(-1)">全部</Button>

                    <Button :type="active === index ? 'info' : 'ghost'" size="small"
                            v-for="(range , index) in markRange"
                            style="margin-left: 10px" @click="rangeClick(index)">
                        {{ range.appraise }} ( {{range.number.length}} )
                    </Button>
                </div>

                <div v-for="departs in departStaffs" class="taskDiv" v-if="!departs.is_depart">
                    <h4 class='depart'>{{ departs.depart }}</h4>

                    <div class="departs" v-for='staff in departs.staffs' v-if="staff.is_task">
                        <div class='staff'>
                            <div>
                                <span>{{ staff.staff}}</span>
                                <span>岗位： {{ staff.position}}</span>
                                <span>绩效总分：{{ finMark[staff.id] ? finMark[staff.id].toFixed(1) : 0 }}</span>
                            </div>
                        </div>
                        <div class='tasks'>
                            <div class='task' v-for='range in markRange' v-if="range.is_task[staff.id]">
                                <div class='appraise' :class="range['active']">{{ range.appraise }}</div>
                                <div class='introduce'>
                                        <span v-for='task in range.tasks[staff.id]' v-if="task">
                                           <Tooltip
                                                   :content="'项目实际占比'+ ( task['is_mark'] ?   ( (mark.mark + (isNotMark[staff.id] ? isNotMark[staff.id] : 0))  / taskMark[staff.id] * 100).toFixed(1) +'%' :'0') "
                                                   v-for="mark in staff.marks" placement="top"
                                                   v-if="attribute[task.task_id] && mark.task_id == task.task_id ">
                                                   {{ taskNames[task['task_id']] }}
                                                <span v-if="task['is_mark']">( {{ task['mark'] }} )</span>
                                                <span v-if="!task['is_mark']">( 未打分 )</span>
                                           </Tooltip>
                                            <Tooltip
                                                     :content="'项目实际占比'+ ( task['is_mark']  ? ( mark.mark  / taskMark[staff.id] * 100).toFixed(1) +'%' :'0') "
                                                     placement="top"
                                                     v-for="mark in staff.marks"
                                                     v-if="!attribute[task.task_id] && mark.task_id == task.task_id">
                                                   {{ taskNames[task['task_id']] }}
                                                <span v-if="task['is_mark']">( {{ task['mark'] }} )</span>
                                                <span v-if="!task['is_mark']">( 未打分 )</span>
                                           </Tooltip>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class='clear'></div>
                    </div>
                </div>
            </Card>
            </Col>
        </Row>
    </div>
</template>

<script>
    import $ from 'jquery';

    function hideStaff () {
        var tasks = document.getElementsByClassName('tasks');
        var length = tasks.length;
        if (length !== 0) {
            for (var i = 0; i < length; i++) {
                let count = $('.tasks').eq(i).find('.task').length;
                // console.log(count + ' -- ' + i)
                if (count === 0) {
                    $('.departs').eq(i).hide();
                } else {
                    $('.departs').eq(i).show();
                }
            }
            init();
        }
    }

    function init () {
        var length = $('.staff').length;
        // console.log(length)
        if (length !== 0) {
            for (var i = 0; i < length; i++) {
                let taskHeigth = 0;
                let taskNum = $('.tasks').eq(i).find('.task').length;
                for (var n = 0; n < taskNum; n++) {
                    taskHeigth += $('.tasks').eq(i).find('.task').eq(n)[0].offsetHeight;
                }
                $('.staff')[i].style.height = taskHeigth < 120 ? '150px' : (taskHeigth + 60) + 'px';
            }

        }

        // if (length !== 0) {
        //     for (var i = 0; i < length; i++) {
        //         let height = tasks[i].offsetHeight;
        //         // staff[i].style.lineHeight = ((length - 3) * 10 + height) + 'px';
        //         staff[i].style.paddingTop = ((length - 3) * 7) + 'px';
        //         staff[i].style.height = ((length - 3) * 10 + height) + 'px';
        //     }
        // }
    }

    export default {
        data () {
            return {
                formData: {
                    mark: [],
                    isMark: [],
                    staffId: [],
                    appraise: [],
                    introduce: [],
                },
                markRange: [{
                    'min': 96.0,
                    'max': 100.0,
                    'appraise': '优秀',
                    'introduce': 'A',
                    'tasks': [],
                    'active': 'activeSuccess',
                    'is_task': [],
                    'number': []
                },
                    {
                        'min': 90.0,
                        'max': 95.9,
                        'appraise': '优良',
                        'introduce': 'B',
                        'tasks': [],
                        'is_task': [],
                        'number': []
                    },
                    {
                        'min': 80.0,
                        'max': 89.9,
                        'appraise': '合格',
                        'introduce': 'C',
                        'tasks': [],
                        'is_task': [],
                        'number': []
                    },
                    {
                        'min': 60,
                        'max': 79.9,
                        'appraise': '不足',
                        'introduce': 'D',
                        'tasks': [],
                        'active': 'activeError',
                        'is_task': [],
                        'number': []
                    },
                    {
                        'min': 1,
                        'max': 59.9,
                        'appraise': '不合格',
                        'introduce': 'E',
                        'tasks': [],
                        'active': 'activeError',
                        'is_task': [],
                        'number': []
                    },
                    {
                        'min': 0,
                        'max': 0,
                        'appraise': '未评价',
                        'introduce': '无',
                        'tasks': [],
                        'is_task': [],
                        'number': []
                    }
                ],
                loading: false,
                active: -1,
                date: '',
                tasks: [],
                taskNames: [],
                departStaffs: [],
                users: [],
                type: true,
                finMark: [],
                isNotMark: [],
                attribute: [],
                taskMark: [],
                depart: '',
                staffSearch: ''
            };
        },
        methods: {
            excelNoteMark(name){
                let date = this.date
                if(name === 'mark'){
                    window.open('/api/note/excel?date='+date)
                }else  if(name === 'staff'){
                    window.open('/api/note/staff_excel?date='+date)
                }
            },

            selectStaff () {
                this.rangeClick(-1);

                Object.values(this.departStaffs).forEach(t => {
                    if (this.staffSearch === '') {
                        t.staffs.forEach(s => {
                            this.$set(s, 'is_task', true);
                            this.$set(t, 'is_depart', false);
                        });
                        return;
                    } else {
                        this.$set(t, 'is_depart', true);
                        Object.values(this.departStaffs).forEach(t => {
                            console.log(this.staffSearch);
                            t.staffs.forEach(s => {
                                // this.$set(t,'is_depart',true)
                                if (s.staff === this.staffSearch) {
                                    this.$set(s, 'is_task', true);
                                    console.log(s);
                                    this.$set(t, 'is_depart', false);
                                } else {
                                    this.$set(s, 'is_task', false);
                                    console.log(s);

                                }
                            });
                        });
                    }
                });
            },
            selectDepart () {
                this.rangeClick(-1);
                Object.values(this.departStaffs).forEach(t => {

                    if (this.depart == -1) {
                        this.$set(t, 'is_depart', false);
                    } else {
                        this.$set(t, 'is_depart', true);
                        if (this.depart == t.id) {
                            this.$set(t, 'is_depart', false);
                        }
                    }
                });
            },
            rangeClick (index) {
                this.active = Number(index);
                this.tasks.forEach(t => {
                    // console.log(index)
                    t.staffs.forEach(e => {
                        this.markRange.forEach((f, key) => {

                            if (f.min <= e.mark && e.mark <= f.max) {
                                if (index === -1 || key === index) {

                                    let tasks = f['tasks'][e.staff_id] || [];
                                    tasks.push(e);
                                    tasks = [...new Set(tasks)];
                                    this.$set(f['is_task'], e.staff_id, 1);
                                    this.$set(f['tasks'], e.staff_id, tasks);

                                } else {
                                    // f['tasks'].splice(e.staff_id, 1);
                                    // f['is_task'].splice(e.staff_id, 1);
                                    this.$set(f['is_task'], e.staff_id, 0);
                                }
                            }
                        });
                    });
                });
                setTimeout(() => {
                    hideStaff();
                }, 10);
            },
            goBack () {
                this.$router.push({
                    name: 'note-month',
                });
            },
            routeType () {
                this.$router.push({
                    name: 'note_task_detail',
                    query: ({
                        date: this.date
                    })
                });
            },

            getMarks () {
                this.JAjax.postJson('staff/fin/mark', {
                    date: this.date
                }, res => {
                    this.finMark = res.data || [];
                });
            },
            getDepartStaffs () {
                this.JAjax.postJson('note/depart/marks', {
                    date:this.$route.query.date
                }, res => {
                    this.departStaffs = res.data || [];
                    this.init();
                    this.getMarks();
                });
            },
            init () {
                this.date = this.$route.query.date;
                if (!this.date) {
                    this.$Message.error('未选择时间');
                } else {
                    this.JAjax.postJson('note/staff/date', {
                        date: this.date
                    }, res => {
                        this.tasks = res.data || [];
                        this.attribute = res.attribute || [];
                        this.isNotMark = res.isNotMark || [];
                        this.taskMark = res.taskMark || [];
                        this.tasks.forEach(t => {

                            t.staffs.forEach(e => {
                                this.markRange.forEach(f => {
                                    if (f.min <= Number(e.mark) && Number(e.mark) <= f.max) {

                                        let tasks = f['tasks'][e.staff_id] || [];
                                        tasks.push(e);
                                        this.$set(f['is_task'], e.staff_id, 1);
                                        this.$set(f['tasks'], e.staff_id, tasks);
                                    }
                                    if(Number(e.mark) === 95.3){
                                        console.log(e.staff_id +'---'+ e.task_id);
                                    }
                                });
                            });
                        });

                        this.taskNames = res.tasks || [];
                        let t = Object.values(this.departStaffs);
                        t.forEach(e => {
                            Object.values(t).forEach(v => {
                                this.markRange.forEach((f) => {
                                    if (f.tasks.length > 0) {
                                        f.tasks.forEach((m, index) => {
                                            v.staffs.forEach(s => {
                                                if (s.id === index) {
                                                    s.is_task = true;
                                                    f.number.push(index);
                                                    f.number = [...new Set(f.number)];
                                                }
                                            });
                                        });
                                    }
                                });
                            });
                        });
                        // console.log(this.markRange);
                    });
                }
            }
        },
        updated () {
            init();
        },
        mounted () {
            this.getDepartStaffs();
        }
    };
</script>
