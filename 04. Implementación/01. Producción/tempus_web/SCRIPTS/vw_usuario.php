<?php

/*
 *
create view vw_usuario as
SELECT u.id, u.email, u.nombre nombreUsuario, u.metodoLogin, u.estado, r.nombre nombreRol 
FROM usuario u
INNER JOIN rol_usuario ru ON ru.usuario_id = u.id
INNER JOIN rol r ON r.id = ru.rol_id
 
*/