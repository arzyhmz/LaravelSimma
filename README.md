### question and todo
1. filtering in changment list system
2. how to update contact in qontact, is that always use create post
3. how to delete in qontact
4. 


### 31 MEI 2023
TABLE CONTACT
$table->string('wa_number')->nullable();
$table->string('IDN')->nullable();
$table->string('wa_countrycode')->nullable(); #success, failed
$table->string('username_wa')->nullable(); #success, failed

### 6Juli migration
php artisan infyom:scaffold logs
$table->string(‘date’);
$table->integer(‘total’);
$table->text(‘list_id’)->nullable();
tambah key field ke logs

tambah simma_id to contact, untuk update


### 12 Juli 2023
add failed_ids to logs
add ast name and 

### 27Juli23
partner_id:
room_id
chat
status
udpate_date


