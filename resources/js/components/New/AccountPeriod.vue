<template>


  <div class="card">

    <form id="msform" @submit.prevent="editmode ? updatePeriod(1) : createPreiod()" @keydown="form.onKeydown($event)">
      <fieldset>
        <div id="content">
          <div class="form-card">
            <h1 class="page-head"> Financial Year</h1>
            <div class="text-center">

              <button :disabled="form.busy" type="button" class="btn  btn-primary" style="min-width:110px"
                      @click="reset_form()">New
              </button>
              <button :disabled="form.busy" type="button" class="btn  btn-primary" style="min-width:110px"
                      @click="reset_list()">List
              </button>
              <button :disabled="form.busy" type="button" class="btn  btn-primary" style="min-width:110px"
                      v-show="editmode">Print
              </button>

            </div>

          </div>
          <div v-if="list_showable" class="form-card">
            <div class="pull-left" style="margin-top:50px;">
              <label for="filter" class="sr-only">Filter</label>
              <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
            </div>
            <vue3-datatable :rows="rows" :columns="columns" :sortable="true" class="advanced-table whitespace-nowrap">
              <template #sl="data">
                <strong class="text-info">{{ data.value.sl }}</strong>
              </template>
              <template #year_start="data">
                <span class="font-semibold">{{ data.value.year_start }}</span>
              </template>
              <template #year_start_date="data">
                <span class="font-semibold">{{ data.value.year_start_date }}</span>
              </template>
              <template #year_end_date="data">
                <span class="font-semibold">{{ data.value.year_end_date }}</span>
              </template>
              <template #period_name="data">
                <span class="font-semibold">{{ data.value.period_name }}</span>
              </template>
              <template #is_current="data">
                <span class="font-semibold">{{ YesArr[data.value.is_current] }}</span>
              </template>
              <template #buttons="data">
                <button class="btn btn-info btn-sm" @click.prevent="showPeriod(data.value.id)">Show</button>
                <button class="btn btn-primary btn-sm" @click.prevent="editPeriod(data.value)">Edit</button>
                <button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deletePeriod(data.value.id)">Delete</button>
              </template>
            </vue3-datatable>
          </div>
          <div class="form-card" v-if="!list_showable">
            <div class="form-folder">
              <h3><i class="fa fa-hand-point-right"></i>General Information:</h3>
              <div class="form-holder">
                <div class="row align-self-stretch">
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-box-outer">
                      <label class="fieldlabels"> Curr Year:</label>
                      <select v-model="form.is_current" name="is_current" class="custom-select" :class="{ 'is-invalid': form.errors.has('is_current') }">
                        <option disabled value="">--Select--</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                      </select>

                      <label class="fieldlabels">Starting Year:</label>
                      <select v-model="form.year_start" name="year_start" class="custom-select" :class="{ 'is-invalid': form.errors.has('year_start') }">
                        <option disabled value="">--Select--</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                      </select>

                      <label class="fieldlabels">Starting Month:</label>
                      <div class="position-relative form-group">
                        <select v-model="form.year_start_month" name="account_type" class="custom-select"
                                @change="accounting_period_calculate()"
                                :class="{ 'is-invalid': form.errors.has('year_start_month') }">
                          <option disabled value="">--Select--</option>
                          <option value="1">January</option>
                          <option value="2">February</option>
                          <option value="3">March</option>
                          <option value="4">April</option>
                          <option value="5">May</option>
                          <option value="6">June</option>
                          <option value="7">July</option>
                          <option value="8">August</option>
                          <option value="9">September</option>
                          <option value="10">October</option>
                          <option value="11">November</option>
                          <option value="12">December</option>
                        </select>
                      </div>
                      <label class="fieldlabels">Ending Month:</label>
                      <div class="position-relative form-group">
                        <select v-model="form.year_end_month" name="year_end_month" class="custom-select"
                                @change="accounting_period_calculate()" :class="{ 'is-invalid': form.errors.has('year_end_month') }">
                          <option disabled value="">--Select--</option>
                          <option value="1">January</option>
                          <option value="2">February</option>
                          <option value="3">March</option>
                          <option value="4">April</option>
                          <option value="5">May</option>
                          <option value="6">June</option>
                          <option value="7">July</option>
                          <option value="8">August</option>
                          <option value="9">September</option>
                          <option value="10">October</option>
                          <option value="11">November</option>
                          <option value="12">December</option>
                        </select>
                      </div>

                      <label class="fieldlabels">Period Name:</label>
                      <input v-model="form.period_name" type="text" name="period_name" :class="{ 'is-invalid': form.errors.has('period_name') }">

                      <label class="fieldlabels">Is Active:</label>
                      <select v-model="form.status_active" name="status_active" class="custom-select" :class="{ 'is-invalid': form.errors.has('status_active') }">
                        <option disabled value="">--Select--</option>
                        <option value="1">Active</option>
                        <option value="2">In-Active</option>
                        <option value="3">Cancel</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="form-box-outer">
                      <h4>Financial Year Details</h4>
                      <table width="450" height="70" border="0"
                             class="table table-hover table-striped" align="center" id="acc_period_table2">
                        <thead>

                        <tr align="left" class="form_caption">
                          <th width="40">SL</th>
                          <th width="120">Starting Date</th>
                          <th width="120">Ending Date</th>
                          <th width="120">Period</th>
                          <th width="50">Locked</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(detail,index) in form.details">

                          <td v-bind:id="'account_period_id_'+index" align="center">
                            <strong>{{ index + 1 }}</strong>
                          </td>
                          <td>
                            <input
                                v-model="detail.id"
                                type="hidden"
                                v-bind:name="'update_id_dtls'+index">
                            <input
                                v-model="detail.month_id"
                                type="hidden"
                                v-bind:name="'month_id_'+index">
                            <input
                                v-model="detail.period_starting_date"
                                type="text" v-bind:name="'period_starting_date_'+index" class="form-control" disabled>


                          </td>
                          <td>
                            <input
                                v-model="detail.period_ending_date"
                                type="text" v-bind:name="'period_ending_date_'+index" class="form-control" disabled>
                          </td>
                          <td>
                            <input
                                v-model="detail.financial_period"
                                type="text"
                                v-bind:name="'period_title_'+index" disabled>
                          </td>
                          <td>
                            <div class="form-check-inline">
                              <input
                                  v-model="detail.period_locked"
                                  type="checkbox"
                                  v-bind:name="'period_locked_'+index">
                            </div>
                          </td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="text-center">
              <button :disabled="form.busy" type="button" class="btn  btn-primary" style="min-width:110px"
                      @click="reset_form()">Refresh
              </button>

              <button :disabled="form.busy || editmode==true || form.posting_status!=0" type="submit"
                      class="btn  btn-primary" style="min-width:110px">New
              </button>

              <button :disabled="form.busy || editmode==false || form.posting_status!=0" type="submit"
                      class="btn  btn-primary" style="min-width:110px">Edit
              </button>

              <button :disabled="form.busy || editmode==false || form.posting_status!=0" type="button"
                      class="btn  btn-primary" style="min-width:110px" @click.prevent="deletePeriod()">Delete
              </button>

              <button :disabled="form.busy || editmode==false || form.posting_status!=0" type="button"
                      class="btn  btn-primary" style="min-width:110px" @click="updatePeriod(2)">Save
              </button>


              <button :disabled="form.busy || editmode==false || form.posting_status!=1" type="button"
                      class="btn  btn-primary" style="min-width:110px" @click="post()">Post
              </button>

              <button :disabled="form.busy || form.posting_status<2" type="button" class="btn  btn-primary"
                      style="min-width:110px" @click="adjust()">Adjust
              </button>

              <button :disabled="form.busy || form.posting_status!=3" type="button" class="btn  btn-primary"
                      style="min-width:110px" @click="repost()">RePost
              </button>

              <button :disabled="form.busy" type="button" class="btn  btn-primary" style="min-width:110px"
                      v-show="editmode" @click="show_pdf()">Preview
              </button>

              <button :disabled="form.busy" type="button" class="btn  btn-primary" style="min-width:110px"
                      v-show="editmode">Print
              </button>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</template>

<script>
import VueTimepicker from 'vue3-timepicker';
import 'vue3-timepicker/dist/VueTimepicker.css';

import { ref } from "vue";
import Vue3Datatable from "@bhplugin/vue3-datatable";
import "@bhplugin/vue3-datatable/dist/style.css";

export default {
  name: 'list-product-categories',
  components: {
    VueTimepicker,
    Vue3Datatable
  },
  data() {
    return {
      filter: '',
      editmode: false,
      save_permission: false,
      update_permission: false,
      delete_permission: false,
      user_menu_name: '',
      list_showable: false,

      form: new Form({
        year_start: '',
        year_start_date: '',
        year_start_month: '',
        year_end_month: '',
        year_end_date: '',
        period_name: '',
        is_current: '',
        status_active: '',
        posting_status: '',
        id: '',
        details: [
          {
            id: '',
            month_id: '',
            period_starting_date: '',
            period_ending_date: '',
            financial_period: '',
            period_locked: false,
            acc_date: '',

          }
        ],

      }),

      columns:  ref([
        {title: 'SL', field: 'sl', align: 'center'},
        {title: 'Year Name', field: 'year_start'},
        {title: 'Year Start', field: 'year_start_date'},
        {title: 'Year End', field: 'year_end_date'},
        {title: 'Period Name', field: 'period_name'},
        {title: 'Is Current', field: 'is_current'},
        {title: '', field: 'buttons', sort: false},
      ]),
      rows: [],

      row: {
        year_start: '',
        year_start_date: '',
        year_end_date: '',
        year_start_month: '',
        year_end_month: '',
        period_name: '',
        is_current: '',
        status_active: '',
        posting_status: '',
        id: '',
        sl: '',
        details: [
          {
            id: '',
            month_id: '',
            period_starting_date: '',
            period_ending_date: '',
            financial_period: '',
            period_locked: false,
            acc_date: '',

          }
        ],
      },
      companies: [],
      company: {
        id: '',
        company_name: '',
      },
      StatusArr: ['Select', 'Active', 'Inactive', 'Cancell'],
      YesArr: ['Select', 'Yes', 'No'],
      page: 1,
      per_page: 10,
    }
  },

  created: function () {
    this.user_menu_name = this.$route.name;
    this.fetchPeroids();
  },

  methods: {
    editPeriod(row) {
      this.form.reset();
      this.editmode = true;
      this.list_showable = false;
      this.form.fill(row);

    },
    accounting_period_calculate() {
      var months = new Array(
          new Array('January', 31),
          new Array('February', 28),
          new Array('March', 31),
          new Array('April', 30),
          new Array('May', 31),
          new Array('June', 30),
          new Array('July', 31),
          new Array('August', 31),
          new Array('September', 30),
          new Array('October', 31),
          new Array('November', 30),
          new Array('December', 31)
      );

      let starting_month = parseInt(this.form.year_start_month);
      let ending_month = parseInt(this.form.year_end_month);
      let diff = ending_month - starting_month;
      this.form.period_name = '';

      if (diff == -1 || diff == 11) {

        if (diff == 11) {
          this.form.period_name = this.form.year_start;
        } else {
          this.form.period_name = this.form.year_start + "-" + (parseInt(this.form.year_start) + 1)
        }

        var k = 0;
        this.form.details.splice(0);
        for (var i = 0; i < 12; i++) {
          if (starting_month + i > 12) {
            var current_month = starting_month + i - 13;
            var c_year = parseInt(this.form.year_start) + 1;
          } else {
            var current_month = starting_month + i - 1;
            var c_year = parseInt(this.form.year_start);
          }
          var c_month = current_month + 1;

          if (i == 0) {
            k = k + 1;
            this.form.year_start_date = c_year + "-" + c_month + "-01",
                this.form.details.push({
                      id: '',
                      month_id: c_month,
                      period_starting_date: months[current_month][0] + ' 1',
                      period_ending_date: months[current_month][0] + ' 1',
                      financial_period: 'Opening',
                      period_locked: false,
                      acc_date: c_year + "-" + c_month + "-" + 1 + "__" + c_year + "-" + c_month + "-" + 1,
                    },
                    {
                      id: '',
                      month_id: c_month,
                      period_starting_date: months[current_month][0] + ' 1',
                      period_ending_date: months[current_month][0] + ' ' + months[current_month][1],
                      financial_period: months[current_month][0],
                      period_locked: false,
                      acc_date: c_year + "-" + c_month + "-" + 1 + "__" + c_year + "-" + c_month + "-" + months[current_month][1]
                    }
                );

          } else if (i == 11) {
            k = k + 1;
            this.form.year_end_date = c_year + "-" + c_month + "-" + months[current_month][1],
                this.form.details.push({
                      id: '',
                      month_id: c_month,
                      period_starting_date: months[current_month][0] + ' 1',
                      period_ending_date: months[current_month][0] + ' ' + months[current_month][1],
                      financial_period: months[current_month][0],
                      period_locked: false,
                      acc_date: c_year + "-" + c_month + "-" + 1 + "__" + c_year + "-" + c_month + "-" + months[current_month][1]
                    },
                    {
                      id: '',
                      month_id: c_month,
                      period_starting_date: months[current_month][0] + ' ' + months[current_month][1],
                      period_ending_date: months[current_month][0] + ' ' + months[current_month][1],
                      financial_period: 'Closing',
                      period_locked: false,
                      acc_date: c_year + "-" + c_month + "-" + months[current_month][1] + "__" + c_year + "-" + c_month + "-" + months[current_month][1]
                    },
                    {
                      id: '',
                      month_id: c_month,
                      period_starting_date: months[current_month][0] + ' ' + months[current_month][1],
                      period_ending_date: months[current_month][0] + ' ' + months[current_month][1],
                      financial_period: 'Post Closing',
                      period_locked: false,
                      acc_date: c_year + "-" + c_month + "-" + months[current_month][1] + "__" + c_year + "-" + c_month + "-" + months[current_month][1]
                    }
                );
          } else {
            k = k + 1;
            this.form.details.push({
                  id: '',
                  month_id: c_month,
                  period_starting_date: months[current_month][0] + ' 1',
                  period_ending_date: months[current_month][0] + ' ' + months[current_month][1],
                  financial_period: months[current_month][0],
                  period_locked: false,
                  acc_date: c_year + "-" + c_month + "-" + 1 + "__" + c_year + "-" + c_month + "-" + months[current_month][1]
                }
            );

          }

        }
      }

    },

    fetchPeroids() {
      let uri = '/Periods';
      window.axios.get(uri).then((response) => {
        this.rows.value = response.data;
      });
    },


    reset_form() {

      this.form.reset();
      this.editmode = false;
      this.list_showable = false;

    },
    reset_list() {
      this.form.reset();
      this.editmode = false;
      let uri = '/Periods';
      window.axios.get(uri).then((response) => {
        this.rows = response.data;
      });
      this.list_showable = true;
    },


    deletePeriod(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {

        this.form.delete('/Periods/' + id).then(() => {

          if (result.value) {
            Swal(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            );
            this.fetchPeroids();
          }

        }).catch(() => {
          Swal("failed!", "there was some wrong", "warning");
        });

      })
    },

    updatePeriod(type) {

      if (type == 2) this.form.posting_status = 1;
      this.form.put('/Periods/' + this.form.id).then(({data}) => {
        var response_data = data.split("**");

        if (response_data[0] * 1 == 1) {
          showToast('Data Update Successfully', 'success');

          this.editAcPeriod(this.form.id);
          this.editmode = true;

        } else {
          showToast('Invalid Operation', 'danger');
        }
      })
      .catch(() => {
        Swal("failed!", "there was some wrong", "warning");

      });
    },


    createPreiod() {

      this.form.post('/Periods').then(({data}) => {
        var response_data = data.split("**");
        if (response_data[0] == 1) {
          showToast('Data Save successfully', 'success');

          this.editAcPeriod(response_data[1]);
          this.editmode = true;

        } else {
          showToast('Invalid Operation', 'danger');
        }

      })
    },
    deletePeriod111() {

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {

        this.form.delete('/Periods/' + this.form.id).then(() => {

          if (result.value) {
            Swal(
                'Deleted!',
                'Your Company has been deleted.',
                'success'
            );
            // this.form.reset();
            this.editAcPeriod();
          }

        }).catch(() => {
          Swal("failed!", "there was some wrong", "warning");
        });

      })
    },


    editAcPeriod(id) {
      this.form.reset();
      this.list_showable = false;
      let uri = '/Periods/' + id + '/edit';
      window.axios.get(uri).then((response) => {
        this.form.fill(response.data);
        this.editmode = true;

      });

    },


    post() {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Post it!'
      }).then((result) => {
        this.form.post('/PeriodPost/' + this.form.id).then((response) => {

          var response_data = response.data.split("**");
          if (response_data[0] == 1) {
            Swal(
                'Posted!',
                'Your Data has been Posted.',
                'success'
            );

            this.editAcPeriod(this.form.id);

          }

        }).catch(() => {
          Swal("failed!", "there was some wrong", "warning");
        });

      })

    },

    repost() {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Repost it!'
      }).then((result) => {
        this.form.post('/PeriodRepost/' + this.form.id).then((response) => {

          var response_data = response.data.split("**");
          if (response_data[0] == 1) {
            Swal(
                'Posted!',
                'Your Data has been Reposted.',
                'success'
            );

            this.editAcPeriod(this.form.id);

          }

        }).catch(() => {
          Swal("failed!", "there was some wrong", "warning");
        });

      })

    },

    adjust() {

      this.form.post('/adjustPeriod/' + this.form.id).then((response) => {
        var response_data = response.data.split("**");
        if (response_data[0] == 1) {
          showToast('Data Update Successfully', 'success');

          this.editAcPeriod(this.form.id);
          this.editmode = true;
        } else {
          showToast('Invalid Operation', 'danger');
        }
      });

    },

  }

}

</script>



