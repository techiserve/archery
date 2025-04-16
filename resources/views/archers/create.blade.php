@extends('template.default')
<style>
  .form-check {
    padding: 10px;
    border: 1px solid #d9dee3;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
  }

  .form-check-input:checked {
    background-color: #696cff;
    border-color: #696cff;
  }

  .form-check-label {
    margin-left: 10px;
    font-weight: 500;
  }
</style>
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Create Archer</h5>
                <form class="card-body"  method="POST" action="/archers/store">
                @csrf
                  <h6>1. Archer Details</h6>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-email">Surname</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="text"
                          name="surname" 
                          id="multicol-email"
                          class="form-control"
                          placeholder="Surname"
                          aria-label="john.doe"
                          aria-describedby="multicol-email2" />
                        <span class="input-group-text" id="multicol-email2"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-password">Date of Birth</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="date"
                            name="dob" 
                            id="dob"
                            onchange="calculateAgeDetails()" 
                            class="form-control"
                            placeholder=""
                            aria-describedby="multicol-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-password2"
                            ></span>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Age Group</label>
                      <input type="text" id="ageCategory"  class="form-control"  name="ag" readonly>
                    </div>

              
                  </div>
                 </br>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Grading Dominant</label>
                      <select class="form-select" id="cgdSelect" name="cgd" aria-label="Default select example">
    <option value="CS1">CS1</option>   
    <option value="CS2">CS2</option>
    <option value="CS3">CS3</option>  
    <option value="JS1">JS1</option>   
    <option value="JS2">JS2</option>
    <option value="JS3">JS3</option>  
    <option value="AS1">AS1</option>   
    <option value="AS2">AS2</option>
    <option value="AS3">AS3</option> 

    <option value="CA1">CA1</option>   
    <option value="CA2">CA2</option>
    <option value="CA3">CA3</option>  
    <option value="JA1">JA1</option>   
    <option value="JA2">JA2</option>
    <option value="JA3">JA3</option>  
    <option value="AA1">AA1</option>   
    <option value="AA2">AA2</option>
    <option value="AA3">AA3</option> 

    <option value="CM1">CM1</option>   
    <option value="CM2">CM2</option>
    <option value="CM3">CM3</option>  
    <option value="JM1">JM1</option>   
    <option value="JM2">JM2</option>
    <option value="JM3">JM3</option>  
    <option value="AM1">AM1</option>   
    <option value="AM2">AM2</option>
    <option value="AM3">AM3</option> 
</select>
                    </div>
                   
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Grading Weak</label>
                      <select class="form-select" id="cgwSelect" name="cgw" aria-label="Default select example">
    <option value="CS1">CS1</option>   
    <option value="CS2">CS2</option>
    <option value="CS3">CS3</option>  
    <option value="JS1">JS1</option>   
    <option value="JS2">JS2</option>
    <option value="JS3">JS3</option>  
    <option value="AS1">AS1</option>   
    <option value="AS2">AS2</option>
    <option value="AS3">AS3</option> 

    <option value="CA1">CA1</option>   
    <option value="CA2">CA2</option>
    <option value="CA3">CA3</option>  
    <option value="JA1">JA1</option>   
    <option value="JA2">JA2</option>
    <option value="JA3">JA3</option>  
    <option value="AA1">AA1</option>   
    <option value="AA2">AA2</option>
    <option value="AA3">AA3</option> 

    <option value="CM1">CM1</option>   
    <option value="CM2">CM2</option>
    <option value="CM3">CM3</option>  
    <option value="JM1">JM1</option>   
    <option value="JM2">JM2</option>
    <option value="JM3">JM3</option>  
    <option value="AM1">AM1</option>   
    <option value="AM2">AM2</option>
    <option value="AM3">AM3</option> 
</select>

                    </div>
                    </div>  
                    </br>
                   
                    <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Proficiency</label>
              
                      <select class="form-select" id="exampleFormControlSelect1" name="cp" aria-label="Default select example">
    <option value="CS1">CS1</option>   
    <option value="CS2">CS2</option>
    <option value="CS3">CS3</option> 
    
    <option value="CA1">CA1</option>   
    <option value="CA2">CA2</option>
    <option value="CA3">CA3</option>  

    <option value="CM1">CM1</option>   
    <option value="CM2">CM2</option>
    <option value="CM3">CM3</option>  

    <option value="JS1">JS1</option>   
    <option value="JS2">JS2</option>
    <option value="JS3">JS3</option>  

    <option value="JA1">JA1</option>   
    <option value="JA2">JA2</option>
    <option value="JA3">JA3</option>  

    <option value="JM1">JM1</option>   
    <option value="JM2">JM2</option>
    <option value="JM3">JM3</option> 

    <option value="AS1">AS1</option>   
    <option value="AS2">AS2</option>
    <option value="AS3">AS3</option> 

    <option value="AA1">AA1</option>   
    <option value="AA2">AA2</option>
    <option value="AA3">AA3</option> 

    <option value="AM1">AM1</option>   
    <option value="AM2">AM2</option>
    <option value="AM3">AM3</option> 
</select>
           
                    </div>
                   
                 

                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-confirm-password">Email</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="email"
                            name="email" 
                            id="multicol-confirm-password"
                            class="form-control"
                            placeholder=""
                            aria-describedby="multicol-confirm-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"
                            ><i class=""></i
                          ></span>
                        </div>
                      </div>
                    </div>
                    </div>  
                    </br>
                    <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Age Group Proficiency</label>
                      <input type="text" id="ageGroup"  class="form-control"  name="agp" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Dominant Hand</label>
                      <select class="form-select" id="exampleFormControlSelect1" name="dh" aria-label="Default select example">
 
                           <option value="Left">Left</option>
                           <option value="Right">Right</option>  
                     </select>
                    </div>

                  </div>

 <div class="row g-6 mt-4">
  <div class="col-md-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="clubMember">
      <label class="form-check-label" for="newsletter">
        Is this Archer a club member?
      </label>
    </div>
  </div>
</div>

                  
                  <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                </form>
              </div>

       
             
</div>
@endsection
<script>
    function calculateAgeDetails() {
        const dobInput = document.getElementById("dob").value;
        const ageCategoryInput = document.getElementById("ageCategory");
        const ageGroupInput = document.getElementById("ageGroup");
        const cgdSelect = document.getElementById("cgdSelect");
        const cgwSelect = document.getElementById("cgwSelect");

        if (!dobInput) return;

        const dob = new Date(dobInput);
        const today = new Date();

        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        let yearOfLiving = today.getFullYear() - dob.getFullYear() + 1;

        let category = "";
        if (age >= 5 && age <= 12) {
            category = "Cub";
        } else if (age >= 13 && age <= 16) {
            category = "Junior";
        } else if (age >= 17) {
            category = "Adult";
        } else {
            category = "Too Young";
        }

        let proficiency = "";
        if (yearOfLiving >= 5 && yearOfLiving <= 12) {
            proficiency = "Cub";
        } else if (yearOfLiving >= 13 && yearOfLiving <= 16) {
            proficiency = "Junior";
        } else if (yearOfLiving >= 17) {
            proficiency = "Adult";
        } else {
            proficiency = "Too Young";
        }

        ageCategoryInput.value = category;
        ageGroupInput.value = proficiency;

        const optionsByCategory = {
    "Cub": ["CS1", "CS2", "CS3", "CA1", "CA2", "CA3", "CM1", "CM2", "CM3"],
    "Junior": ["JS1", "JS2", "JS3", "JA1", "JA2", "JA3", "JM1", "JM2", "JM3"],
    "Adult": ["AS1", "AS2", "AS3", "AA1", "AA2", "AA3", "AM1", "AM2", "AM3"]
};
        // Helper to populate dropdown options
        function populateOptions(selectElement, category) {
            selectElement.innerHTML = "";

            if (optionsByCategory[category]) {
                optionsByCategory[category].forEach(value => {
                    const option = document.createElement("option");
                    option.value = value;
                    option.text = value;
                    selectElement.appendChild(option);
                });
            } else {
                const option = document.createElement("option");
                option.value = "";
                option.text = "N/A";
                selectElement.appendChild(option);
            }
        }

        // Update both selects
        populateOptions(cgdSelect, category);
        populateOptions(cgwSelect, category);
    }
</script>
