@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Score Card History</h5>
                <form class="card-body"  method="POST" action="/grading/confirmscores">
                @csrf
                <h6> Event Details</h6>
                  <div class="row g-12">
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" value="{{$grading->name}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Date</label>
                      <input type="text" id="multicol-username" name="date"  value="{{$grading->date}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <!-- <div class="col-md-4">
                    
                      <label class="form-label" for="multicol-username">Event Category</label>
                      <input type="text" id="multicol-username" name="eventcategory"  value="{{$grading->eventcategory}}" class="form-control" placeholder="John Doe" />
                    </div> -->
                    
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Bow Used</label>
                      <input type="text" id="multicol-username" name="bowused"  value="{{$grading->bowUsed}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Current Grading</label>
                      <input type="text" id="multicol-username" name="curentgrading"  value="{{$grading->currentGrading}}"  class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                    <label class="form-label" for="multicol-email">Grading for </label>
                   
                      <input type="text" id="multicol-username" name="gradefor"  value="{{$grading->gradingfor}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                    <label class="form-label" for="multicol-username">Age Category</label>
                    <input type="text" id="multicol-username" name="age"  value="{{$grading->ageCategory}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                      <div class="form-password-toggle">
                      <label class="form-label" for="multicol-username">Arrow Used</label>
                      <input type="text" id="multicol-username" name="arrow"  value="{{$grading->arrowsUsed}}" class="form-control" placeholder="John Doe" />
                      </div>
                    </div>
            
                    
    
              </div>
                        
</div>


    <!-- DataTable with Checkboxes -->
    <!-- <div class="card">
        <div class="card-datatable text-nowrap">
        <div class="table-responsive">
            <table class="datatables-basic table table-bordered table-responsive">
                <thead>
                    <tr>
                       
                        <th></th>
                        <th>Arrow 1</th>
                        <th>Arrow 2</th>
                        <th>Arrow 3</th>
                        <th>Arrow 4</th>
                        <th>Arrow 5</th>
                        <th>Arrow 6</th>
                        <th>Round Total</th>
                        <th>Cum Total</th>
                        <th>Event Time</th>
                        <th>Current P/R</th>
                        <th>Required P/R</th>
                    </tr>
                </thead>
                <tbody>
                   
               <tr>
                        <td>Round 1</td>
                        <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field11" id="field11" class="form-control dt-input dt-full-name input-number"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field12" id="field12" class="form-control dt-input dt-full-name input-number"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field13" id="field13" class="form-control dt-input dt-full-name input-number"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field14" id="field14" class="form-control dt-input dt-full-name input-number"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field15" id="field15" class="form-control dt-input dt-full-name input-number"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field16" id="field16" class="form-control dt-input dt-full-name input-number"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total" id="total" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text" name="cumtotalfirst" id="cumtotalfirst" class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>

                      <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="current" id="current" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="required" id="required" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td>
              </tr>

               <tr>
                    <td>Round 2</td>
                    <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field21" id="field21" class="form-control dt-input dt-full-name input-number-2"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field22" id="field22" class="form-control dt-input dt-full-name input-number-2"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field23" id="field23" class="form-control dt-input dt-full-name input-number-2"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field24" id="field24" class="form-control dt-input dt-full-name input-number-2"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field25" id="field25" class="form-control dt-input dt-full-name input-number-2"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field26" id="field26" class="form-control dt-input dt-full-name input-number-2"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total2" id="total2" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text" name="cumtotal2" id="cumtotal2"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" name="time2" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
             </tr>
                
             <tr>
                   <td>Round 3</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field31" id="field31" class="form-control dt-input dt-full-name input-number-3"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field32" id="field32" class="form-control dt-input dt-full-name input-number-3"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field33" id="field33" class="form-control dt-input dt-full-name input-number-3"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field34" id="field34" class="form-control dt-input dt-full-name input-number-3"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field35" id="field35" class="form-control dt-input dt-full-name input-number-3"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field36" id="field36" class="form-control dt-input dt-full-name input-number-3"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total3" id="total3" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text" name="cumtotal3" id="cumtotal3"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
           </tr>
                
            <tr>
                   <td>Round 4</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field41" id="field41" class="form-control dt-input dt-full-name input-number-4"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field42" id="field42" class="form-control dt-input dt-full-name input-number-4"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field43" id="field43" class="form-control dt-input dt-full-name input-number-4"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field44" id="field44" class="form-control dt-input dt-full-name input-number-4"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field45" id="field45" class="form-control dt-input dt-full-name input-number-4"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field46" id="field46" class="form-control dt-input dt-full-name input-number-4"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total4" id="total4" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text"   name="cumtotal4" id="cumtotal4"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
           </tr>
                
            <tr>
                   <td>Round 5</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field51" id="field51" class="form-control dt-input dt-full-name input-number-5"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field52" id="field52" class="form-control dt-input dt-full-name input-number-5"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field53" id="field53" class="form-control dt-input dt-full-name input-number-5"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field54" id="field54" class="form-control dt-input dt-full-name input-number-5"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field55" id="field55" class="form-control dt-input dt-full-name input-number-5"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field56" id="field56" class="form-control dt-input dt-full-name input-number-5"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total5" id="total5" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text"  name="cumtotal5" id="cumtotal5"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
            </tr>
                
            <tr>
                   <td>Round 6</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field61" id="field61" class="form-control dt-input dt-full-name input-number-6"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field62" id="field62" class="form-control dt-input dt-full-name input-number-6"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field63" id="field63" class="form-control dt-input dt-full-name input-number-6"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field64" id="field64" class="form-control dt-input dt-full-name input-number-6"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field65" id="field65" class="form-control dt-input dt-full-name input-number-6"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field66" id="field66" class="form-control dt-input dt-full-name input-number-6"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total6" id="total6" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text"  name="cumtotal6" id="cumtotal6"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
           </tr>
                
            <tr>
                   <td>Round 7</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field71" id="field71" class="form-control dt-input dt-full-name input-number-7"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field72" id="field72" class="form-control dt-input dt-full-name input-number-7"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field73" id="field73" class="form-control dt-input dt-full-name input-number-7"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field74" id="field74" class="form-control dt-input dt-full-name input-number-7"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field75" id="fiel715" class="form-control dt-input dt-full-name input-number-7"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field76" id="field76" class="form-control dt-input dt-full-name input-number-7"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total7" id="total7"    class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text"  name="cumtotal7" id="cumtotal7"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
          </tr>
                
           <tr>
                   <td>Round 8</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field81" id="field81" class="form-control dt-input dt-full-name input-number-8"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field82" id="field82" class="form-control dt-input dt-full-name input-number-8"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field83" id="field83" class="form-control dt-input dt-full-name input-number-8"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field84" id="field84" class="form-control dt-input dt-full-name input-number-8"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field85" id="field85" class="form-control dt-input dt-full-name input-number-8"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field86" id="field86" class="form-control dt-input dt-full-name input-number-8"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total8" id="total8" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text"  name="cumtotal8" id="cumtotal8"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
           </tr>
                
           <tr>
                   <td>Round 9</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field91" id="field91" class="form-control dt-input dt-full-name input-number-9"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field12" id="field12" class="form-control dt-input dt-full-name input-number-9"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field13" id="field13" class="form-control dt-input dt-full-name input-number-9"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field14" id="field14" class="form-control dt-input dt-full-name input-number-9"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field15" id="field15" class="form-control dt-input dt-full-name input-number-9"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field16" id="field16" class="form-control dt-input dt-full-name input-number-9"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total9" id="total9" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"><input type="text"  name="cumtotal9" id="cumtotal9"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
         </tr>

         <tr>
                   <td>Total</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="grandtotal" id="grandtotal" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"></div></td>
         </tr>
        
                </tbody>
            </table>
        </div>
       </div>
    </div> -->



<!-- the refined table structure -->

    <div class="card">
        <div class="card-datatable text-nowrap">
        <div class="table-responsive">
            <table class="datatables-basic table table-bordered table-responsive">
                <thead>
                    <tr>
                       
                        <th></th>
                        <th>Round 1</th>
                        <th>Round 2</th>
                        <th>Round 3</th>
                        <th>Round 4</th>
                        <th>Round 5</th>
                        <th>Round 6</th>
                        <th>Round 7</th>
                        <th>Round 8</th>
                        <th>Round 9</th>
                 
                    </tr>
                </thead>
                <tbody>
                   
               <tr>
                        <td>Arrow 1</td>
                        <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field11" id="field11" class="form-control dt-input dt-full-name input-number" readonly value="{{$Round1->arrow1}}" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field21" id="field21" class="form-control dt-input dt-full-name input-number-2" readonly value="{{$Round2->arrow1}}"   required/>
                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field31" id="field31" class="form-control dt-input dt-full-name input-number-3" readonly value="{{$Round3->arrow1}}"  required/>

                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field41" id="field41" class="form-control dt-input dt-full-name input-number-4" readonly value="{{$Round4->arrow1}}"  required/>

                   
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field51" id="field51" class="form-control dt-input dt-full-name input-number-5" readonly value="{{$Round5->arrow1}}"  required/>

                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field61" id="field61" class="form-control dt-input dt-full-name input-number-6" readonly value="{{$Round6->arrow1}}"  required/>

                  
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field71" id="field71" class="form-control dt-input dt-full-name input-number-7" readonly value="{{$Round7->arrow1}}"  required/>

                     
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                <input type="text" name="field81" id="field81" class="form-control dt-input dt-full-name input-number-8"  readonly value="{{$Round8->arrow1}}"  required/>

               
                </div></td>
                      
                      <td>
                        <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field91" id="field91" class="form-control dt-input dt-full-name input-number-9" readonly value="{{$Round9->arrow1}}"  required/>

                      
                        </div></td>

                      <!-- <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="current" id="current" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="required" id="required" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td> -->
              </tr>

               <tr>
                    <td>Arrow 2</td>
                    <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field12" id="field12" class="form-control dt-input dt-full-name input-number" readonly value="{{$Round1->arrow2}}"  required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field22" id="field22" class="form-control dt-input dt-full-name input-number-2" readonly value="{{$Round2->arrow2}}"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field32" id="field32" class="form-control dt-input dt-full-name input-number-3" readonly value="{{$Round3->arrow2}}"  required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field42" id="field42" class="form-control dt-input dt-full-name input-number-4" readonly value="{{$Round4->arrow2}}"  required/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field52" id="field52" class="form-control dt-input dt-full-name input-number-5" readonly value="{{$Round5->arrow2}}"  required/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field62" id="field62" class="form-control dt-input dt-full-name input-number-6" readonly value="{{$Round6->arrow2}}"   required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field72" id="field72" class="form-control dt-input dt-full-name input-number-7" readonly value="{{$Round7->arrow2}}"  required/>

                      
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                <input type="text" name="field82" id="field82" class="form-control dt-input dt-full-name input-number-8" readonly value="{{$Round8->arrow2}}"  required/>
                
                </div></td>
                      
                      <td><div class="col-sm-6 col-lg-10">
                      <input type="text" name="field92" id="field92" class="form-control dt-input dt-full-name input-number-9" readonly value="{{$Round9->arrow2}}"  required/>
  
                        
                    </div></td>
             </tr>
                
             <tr>
                   <td>Arrow 3</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                        
                    <input type="text" name="field13" id="field13" class="form-control dt-input dt-full-name input-number" readonly value="{{$Round1->arrow3}}"  required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field23" id="field23" class="form-control dt-input dt-full-name input-number-2" readonly value="{{$Round2->arrow3}}"  required/>
                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field33" id="field33" class="form-control dt-input dt-full-name input-number-3" readonly value="{{$Round3->arrow3}}" />
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field43" id="field43" class="form-control dt-input dt-full-name input-number-4" readonly  value="{{$Round4->arrow3}}"  required/>

                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field53" id="field53" class="form-control dt-input dt-full-name input-number-5" readonly  value="{{$Round5->arrow3}}"  required/>

                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field63" id="field63" class="form-control dt-input dt-full-name input-number-6" readonly  value="{{$Round6->arrow3}}"  required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        
                    <input type="text" name="field73" id="field73" class="form-control dt-input dt-full-name input-number-7" readonly  value="{{$Round7->arrow3}}"  required/>

                     
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                <input type="text" name="field83" id="field83" class="form-control dt-input dt-full-name input-number-8" readonly  value="{{$Round8->arrow3}}"  required/>

                </div></td>
                      
                      <td><div class="col-sm-6 col-lg-10">
                      <input type="text" name="field93" id="field93" class="form-control dt-input dt-full-name input-number-9" readonly  value="{{$Round9->arrow3}}"  required/>

                    </div></td>
           </tr>
                
            <tr>
                   <td>Arrow 4</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field14" id="field14" class="form-control dt-input dt-full-name input-number" readonly  value="{{$Round1->arrow4}}"  required/>
                    
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field24" id="field24" class="form-control dt-input dt-full-name input-number-2" readonly  value="{{$Round2->arrow4}}"  required/>
                
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field34" id="field34" class="form-control dt-input dt-full-name input-number-3" readonly  value="{{$Round3->arrow4}}"  required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field44" id="field44" class="form-control dt-input dt-full-name input-number-4" readonly  value="{{$Round4->arrow4}}"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field54" id="field54" class="form-control dt-input dt-full-name input-number-5" readonly  value="{{$Round5->arrow4}}"  required/>

            
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field64" id="field64" class="form-control dt-input dt-full-name input-number-6" readonly  value="{{$Round6->arrow4}}"  required/>

                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field74" id="field74" class="form-control dt-input dt-full-name input-number-7" readonly  value="{{$Round7->arrow4}}"  required/>
                     
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                <input type="text" name="field84" id="field84" class="form-control dt-input dt-full-name input-number-8" readonly  value="{{$Round8->arrow4}}"  required/>
                 
                </div></td>
                      
                      <td><div class="col-sm-6 col-lg-10">
                      <input type="text" name="field94" id="field94" class="form-control dt-input dt-full-name input-number-9" readonly  value="{{$Round9->arrow4}}"  required/>
                   
                    </div></td>
           </tr>
                
            <tr>
                   <td>Arrow 5</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field15" id="field15" class="form-control dt-input dt-full-name input-number" readonly  value="{{$Round1->arrow5}}"  required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field25" id="field25" class="form-control dt-input dt-full-name input-number-2" readonly  value="{{$Round2->arrow5}}"  required/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field35" id="field35" class="form-control dt-input dt-full-name input-number-3"  readonly value="{{$Round3->arrow5}}"  required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field45" id="field45" class="form-control dt-input dt-full-name input-number-4" readonly  value="{{$Round4->arrow5}}"  required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field55" id="field55" class="form-control dt-input dt-full-name input-number-5" readonly  value="{{$Round5->arrow5}}"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field65" id="field65" class="form-control dt-input dt-full-name input-number-6" readonly  value="{{$Round6->arrow5}}"  required/>

                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field75" id="fiel75" class="form-control dt-input dt-full-name input-number-7" readonly  value="{{$Round7->arrow5}}"  required/>

                     
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                <input type="text" name="field85" id="field85" class="form-control dt-input dt-full-name input-number-8" readonly  value="{{$Round8->arrow5}}"  required/>

                    
                </div></td>
                      
                      <td><div class="col-sm-6 col-lg-10">
                      <input type="text" name="field95" id="field95" class="form-control dt-input dt-full-name input-number-9" readonly  value="{{$Round9->arrow5}}"  required/>

         
                    </div></td>
            </tr>
                
            <tr>
                   <td>Arrow 6</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field16" id="field16" class="form-control dt-input dt-full-name input-number"  readonly value="{{$Round1->arrow6}}"  required/>

                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field26" id="field26" class="form-control dt-input dt-full-name input-number-2" readonly  value="{{$Round2->arrow6}}"  required/>

                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field36" id="field36" class="form-control dt-input dt-full-name input-number-3" readonly  value="{{$Round3->arrow6}}"  required/>

                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field46" id="field46" class="form-control dt-input dt-full-name input-number-4" readonly  value="{{$Round4->arrow6}}"  required/>

                   
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field56" id="field56" class="form-control dt-input dt-full-name input-number-5" readonly   value="{{$Round5->arrow6}}"  required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="field66" id="field66" class="form-control dt-input dt-full-name input-number-6" readonly  value="{{$Round6->arrow6}}"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="field76" id="field76" class="form-control dt-input dt-full-name input-number-7"  readonly value="{{$Round7->arrow6}}"  required/>

                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                    <input type="text" name="field86" id="field86" class="form-control dt-input dt-full-name input-number-8"  readonly value="{{$Round8->arrow6}}"  required/>

                </div></td>
                      
                      <td><div class="col-sm-6 col-lg-10">
                      <input type="text" name="field96" id="field96" class="form-control dt-input dt-full-name input-number-9" readonly  value="{{$Round9->arrow6}}"  required/>

                    </div></td>
           </tr>
                
            <tr>
                   <td>Round Total</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="total" id="total" class="form-control dt-input dt-full-name" readonly  value=" {{$Round1->roundtotal}}"  required/>
                    
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="total2" id="total2" class="form-control dt-input dt-full-name" readonly  value="{{$Round2->roundtotal}}"  required/>
                  
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="total3" id="total3" class="form-control dt-input dt-full-name" readonly  value="{{$Round3->roundtotal}}"  required/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="total4" id="total4" class="form-control dt-input dt-full-name" readonly  value="{{$Round4->roundtotal}}"  required/>
                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="total5" id="total5" class="form-control dt-input dt-full-name" readonly  value="{{$Round5->roundtotal}}"  required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="total6" id="total6" class="form-control dt-input dt-full-name" readonly  value="{{$Round6->roundtotal}}"  required/>
                     
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        <input type="text" name="total7" id="total7"    class="form-control dt-input dt-full-name" readonly  value="{{$Round7->roundtotal}}"  required/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                <input type="text" name="total8" id="total8" class="form-control dt-input dt-full-name" readonly  value="{{$Round8->roundtotal}}"  required/>
                 
                </div></td>
                      
                      <td><div class="col-sm-6 col-lg-10">
                      <input type="text" name="total9" id="total9" class="form-control dt-input dt-full-name" readonly  value="{{$Round9->roundtotal}}"  required/>
                     
                    </div></td>
          </tr>
                
           <tr>
                   <td>Cum Total </td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="cumtotalfirst" id="cumtotalfirst" class="form-control dt-input dt-full-name" readonly value="{{$Round1->cumtotal}}" />
                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="cumtotal2" id="cumtotal2"  class="form-control dt-input dt-full-name" readonly value="{{$Round2->cumtotal}}"/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="cumtotal3" id="cumtotal3"  class="form-control dt-input dt-full-name" readonly value="{{$Round3->cumtotal}}" />
                  
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text"   name="cumtotal4" id="cumtotal4"  class="form-control dt-input dt-full-name" readonly value="{{$Round4->cumtotal}}"/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text"  name="cumtotal5" id="cumtotal5"  class="form-control dt-input dt-full-name" readonly value="{{$Round5->cumtotal}}"/>
                     
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text"  name="cumtotal6" id="cumtotal6"  class="form-control dt-input dt-full-name" readonly  value="{{$Round6->cumtotal}}" />
                     
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text"  name="cumtotal7" id="cumtotal7"  class="form-control dt-input dt-full-name" readonly value="{{$Round7->cumtotal}}" />
                      
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                    <input type="text"  name="cumtotal8" id="cumtotal8"  class="form-control dt-input dt-full-name" readonly  value="{{$Round8->cumtotal}}" />
                </div></td>
                      
                      <td><div class="col-sm-6 col-lg-10">
                      <input type="text"  name="cumtotal9" id="cumtotal9"  class="form-control dt-input dt-full-name" readonly value="{{$Round9->cumtotal}}" />
                   
                    </div></td>
           </tr>
                
           <tr>
                   <td>Time</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" class="form-control"  name="time1" placeholder="HH:MM" id="flatpickr-time" readonly value="{{$Round1->time}}" />
                 
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" class="form-control" name="time2" placeholder="HH:MM" id="flatpickr-time1" readonly value="{{$Round2->time}}" />
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" class="form-control" name="time3" placeholder="HH:MM" id="flatpickr-time" readonly value="{{$Round3->time}}" />
                     
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" class="form-control" name="time4" placeholder="HH:MM" id="flatpickr-time" readonly value="{{$Round4->time}}" />
                
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" class="form-control" name="time5" placeholder="HH:MM" id="flatpickr-time" readonly value="{{$Round5->time}}" />
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" class="form-control" name="time6" placeholder="HH:MM" id="flatpickr-time" readonly value="{{$Round6->time}}"/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" class="form-control" name="time7" placeholder="HH:MM" id="flatpickr-time" readonly value="{{$Round7->time}}"/>
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10">
                <input type="text" class="form-control" name="time8" placeholder="HH:MM" id="flatpickr-time" readonly value="{{$Round8->time}}" />
                </div></td>
                      
                      <td><div class="col-sm-6 col-lg-10">
                      <input type="text" class="form-control" name="time9" placeholder="HH:MM" id="flatpickr-time" readonly value="{{$Round9->time}}" />
                    </div></td>
         </tr>

         <tr>
                   <td>Total</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="grandtotal" id="grandtotal" class="form-control dt-input dt-full-name" readonly  value="{{$Round9->grandtotal}}"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                      
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"></div></td>
         </tr>
         <tr>
                   <td>Current P/R</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="current" id="current" class="form-control dt-input dt-full-name" readonly   value=""  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                        
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"></div></td>
         </tr>
         <tr>
                   <td>Required P/R</td>
                   <td>
                    <div class="col-sm-6 col-lg-10">
                    <input type="text" name="required" id="required" class="form-control dt-input dt-full-name"  readonly  value=""  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    </div>
                </td>
                <td>
                    <div class="col-sm-6 col-lg-10">
                    
                    </div>
                </td>
                <td><div class="col-sm-6 col-lg-10"></div></td>
                      
                      <td><div class="col-sm-6 col-lg-10"></div></td>
         </tr>
        
                </tbody>
            </table>
        </div>
       </div>
    </div>
    
 
</form>

            
@endsection