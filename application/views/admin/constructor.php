<div class="right_col" role="main">
  <div class="row">
    <div>
      <div class="new-tarif">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_content">
              <h2>Настройки маркетинга</h2>
              <div class="block-stat-style">
                <p style="color:red;"></p>
                <p style="color:green;"></p>
                <form action="tarif_setts4" method="post">
                  <h3 class="text-center">Добавить тариф</h3>
                  <br>
                  <div class="admin-row">
                    <span class="half">Название:</span>
                    <input type="text" name="bprice_in" value="Название"> 
                  </div>
                  <div class="admin-row">
                    <span class="half">Количество чел: </span>
                    <input type="text" name="bprice_in" value="Количество">
                  </div>
                  <div class="admin-row">
                    <span class="half">Стоимость: </span>
                    <input type="text" name="bprice_in" value="Стоимость"> $
                  </div>
                  <div class="admin-row" style="text-align: center; padding-top:10px;">
                    <input class="style-btn" type="submit" name="save" value="Создать">
                  </div>
                </form>
              </div>
              <hr>
              <div class="info-tarif-select">
                <form  class="search-select">
                   <!--  -->
                  <div class="input-group">
                    <select name="type" class="form-control">
                      Выбрать тариф
                      <option >Тариф 1</option>
                      <option >Тариф 2</option>
                      <option >Тариф 3</option>
                      <option >Тариф 4</option>
                    </select>
                  </div>
                </form>
                <div class="text-center">
                  <div class="block-left-select-tarif">
                    <form action="tarif_setts4" method="post" class="block-stat-style">
                      <div class="admin-row">
                        <span class="half">Название:</span>
                        <input type="text" name="bprice_in" value="Название"> 
                      </div>
                      <div class="admin-row">
                        <span class="half">Количество чел: </span> <b>10</b>
                      </div>
                      <div class="admin-row">
                        <span class="half">Стоимость входа: </span>
                        <input type="text" name="bprice_in" value="Стоимость"> $
                      </div>
                    </form>
                  </div>
                  <div class="block-left-select-tarif">
                    <table class="table table-striped jambo_table">
                      <thead>  
                        <tr>
                          <th>Номер уровня</th>
                          <th>% начислений</th>
                        </tr>
                      </thead>
                      <tr>
                        <td>1</td>
                        <td>5%</td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>10%</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
