<template>
  <div class="container" v-if="the_user">
    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <h4 class="header">
          <center>เพิ่มงานวิจัย</center>
        </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-xs-12"></div>
      <div class="col-lg-6 col-xs-12">
        <form @submit.prevent="submitResearch">
          หัวข้อ
          <input
            type="text"
            v-model="research.r_title"
            class="form-control"
            placeholder="หัวข้อ"
            required
          />
          <br />หัวข้อทางเลือก
          <input
            type="text"
            v-model="research.r_titlealternative"
            class="form-control"
            placeholder="หัวข้อทางเลือก"
            required
          />
          <br />
          <!-- Creator
                    <input type="text" v-model="research.r_creator" class="form-control" required>
          <br>-->
          เรื่อง
          <input
            type="text"
            v-model="research.r_subject"
            class="form-control"
            placeholder="เรื่อง"
            required
          />
          <br />รายละเอียด
          <textarea
            v-model="research.r_description"
            class="form-control textarea"
            placeholder="รายละเอียด"
            rows="6"
          ></textarea>
          <br />ผู้เผยแพร่
          <textarea
            v-model="research.r_publisher"
            class="form-control textarea"
            placeholder="ผู้เผยแพร่"
            rows="3"
          ></textarea>
          <br />วันที่เผยแพร่
          <input
            type="text"
            v-model="research.r_createddate"
            class="form-control"
            placeholder="วันที่เผยแพร่"
            required
          />
          <br />วันที่แก้ไข
          <input
            type="text"
            v-model="research.r_modifieddate"
            class="form-control"
            placeholder="วันที่แก้ไข"
            required
          />
          <br />วันที่ตีพิมพ์
          <input
            type="text"
            v-model="research.r_issueddate"
            class="form-control"
            placeholder="วันที่ตีพิมพ์"
            required
          />
          <br />ประเภท
          <input
            type="text"
            v-model="research.r_type"
            class="form-control"
            placeholder="ประเภท"
            required
          />
          <br />ขนาด
          <input
            type="text"
            v-model="research.r_format"
            class="form-control"
            placeholder="ขนาด"
            required
          />
          <br />แหล่งข้อมูล
          <input
            type="text"
            v-model="research.r_source"
            class="form-control"
            placeholder="แหล่งข้อมูล"
            required
          />
          <br />ภาษา
          <input
            type="text"
            v-model="research.r_language"
            class="form-control"
            placeholder="ภาษา"
            required
          />
          <br />สิทธิประโยชน์
          <textarea
            v-model="research.r_rights"
            class="form-control textarea"
            placeholder="สิทธิประโยชน์"
            rows="5"
          ></textarea>
          <br />สิทธิ์การเข้าถึง ( ** ระดับที่เลือกและระดับที่สูงกว่าจะสามารถเข้าดูได้ )
          <select
            v-model="research.r_permission"
            class="form-control select"
            required
          >
            <option class="option" selected disabled value>กำหนด สิทธิ์การเข้าถึง</option>
            <option
              class="option"
              v-for="(mt,index) in Member_Type"
              :key="index"
              :value="mt.mt_id"
            >{{ mt.mt_name }}</option>
          </select>
          <br />
          <br />
          <h5>Files [ {{files.length}} ] Size Files All [ {{max_size_file}} byte ]</h5>
          <input
            type="file"
            ref="files"
            style="display: none;"
            id="FileUpload1"
            @change="handleFileUpload"
            multiple
          />
          <br />
          <div class="row" v-for="(f,index) in files" :key="index">
            <div class="col-lg-10">
              <input
                type="text"
                class="form-control"
                v-model="file_title[index]"
                placeholder="File Title"
                required
              />
              <b>{{index+1}}. File</b>
              {{files[index].name }}
              <b>Size</b>
              {{files[index].size}} byte
              <br />
              <br />
            </div>
            <div class="col-lg-2">
              <button type="button" class="form-control btn-danger" @click="RemoveRow(index)">ลบ</button>
              <br />
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-lg-6">
              <button
                type="button"
                class="form-control btn-primary col-lg-12"
                @click="ChooseFiles"
              >เลือกไฟล์</button>
              <br />
            </div>
            <div class="col-lg-6">
              <button type="submit" class="form-control btn-primary col-12">ดำเนินการต่อ</button>
              <br />
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-3 col-xs-12"></div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      research: {
        r_title: "",
        r_titlealternative: "",
        // r_creator:'',
        r_subject: "",
        r_description: "",
        r_publisher: "",
        r_createddate: "",
        r_modifieddate: "",
        r_issueddate: "",
        r_type: "",
        r_format: "",
        r_source: "",
        r_language: "",
        r_rights: "",
        r_permission: ""
      },
      files: [],
      max_size_file: 0,
      file_title: []
    };
  },
  methods: {
    // files
    ChooseFiles() {
      document.getElementById("FileUpload1").click();
    },
    handleFileUpload(event) {
      this.files = [];
      this.file_title = [];

      var i = 0;
      let uploadedFiles = this.$refs.files.files;
      for (var i = 0; i < uploadedFiles.length; i++) {
        this.files.push(uploadedFiles[i]);
        this.max_size_file = this.max_size_file + uploadedFiles[i].size;
      }
      if (this.max_size_file > 10000000) {
        this.files = [];
        this.max_size_file = 0;
        // alert
        this.$swal("Your file is larger than 10 MB. Sorry Choose Again !!!");
      }
    },
    RemoveRow: function(index) {
      this.max_size_file = this.max_size_file - this.files[index].size;
      this.files.splice(index, 1);
      this.file_title.splice(index, 1);
    },
    //submit
    submitResearch() {
      var jsonResearch = JSON.stringify(this.research);
      var jsonFiles_Title = JSON.stringify(this.file_title);
      var FD = new FormData();
      if (this.files.length != 0) {
        for (var i = 0; i < this.files.length; i++) {
          FD.append("userfileupload" + i, this.files[i]);
        }
        FD.append("file_title", jsonFiles_Title);
      }
      FD.append("research", jsonResearch);
      FD.append("creator", JSON.stringify(this.$store.state.log_on));
      this.$store.dispatch("Add_Research", FD);
      setTimeout(() => {
        this.$router.go(-1);
      }, 2000);
      this.$swal("Save Research Success .", "", "success");
    }
  },
  computed: {
    the_user() {
      var user = this.$store.getters.getThe_User;
      if (user.m_status != "admin") {
        // this.$router.go(-1)
      }
      return user;
    },
    Member_Type() {
      return this.$store.getters.getMember_Type;
    }
  }
};
</script>