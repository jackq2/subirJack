/*
 insert into
 */
INSERT INTO estudiantes (nombres, apellidomat, apellidopat, grupo, prof_autor) VALUES ('eduardo de jesus', 'zavala', 'chable' , 'ISMA-5','1');
/*
inner join
*/
SELECT estudiantes.*, cuentas.username AS Teacher
FROM estudiantes
         INNER JOIN cuentas ON estudiantes.prof_autor = cuentas.id_user;
/*
subqueries
*/
SELECT estudiantes.*,
       (SELECT username FROM cuentas WHERE id_user = estudiantes.prof_autor) AS Profesor
FROM estudiantes;
/*
set
*/
UPDATE cuentas
SET password = 'echaleganasmami'
WHERE id_user = 5;
/*
views
*/
CREATE VIEW studentsANDteachers AS
SELECT estudiantes.*, cuentas.username AS Profe
FROM estudiantes
         INNER JOIN cuentas ON estudiantes.prof_autor = cuentas.id_user;

/*
 select para ver todo
 */
SELECT * FROM cuentas;
SELECT * FROM estudiantes;
SELECT * FROM studentsANDteachers;
