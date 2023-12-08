<?php

use Sienekib\Mehael\Database\Factory\Schema;

class {migration}
{
	public function up()
	{
		Schema::create('{table}', "
			`{table_id}` int(11) not null auto_increment,
			# uuid varchar(250) not null,

			#  -- coloque aqui o seu sql

			`created_at` timestamp not null default current_timestamp,
			`updated_at` timestamp null
			primary key(`{table_id}`)
		");
	}

	public function down()
	{
		Schema::dropIfExists('{table}');
	}
}