import { Selector } from 'testcafe';
import { Role } from 'testcafe';

fixture `User actions`
  .page `http://localhost:8000/home`;

const userLogged = Role('http://localhost:8000/login', async t => {
await t
    .typeText('#email', 'user@user.com')
    .typeText('#password', 'user')
    .click('.btn-primary');
});

test('navigation', async t => {
    await t
        .useRole(userLogged)
        .wait(2000)
        .click('#navbarDropdown')
        .wait(1000)
		.click('#edit')
		.wait(2000)
		.typeText('#username', 'JFPiège',{ replace: true })
    	.typeText('#address', '7 Rue d\'Aguesseau',{ replace: true })
    	.typeText('#postal_code', '75008',{ replace: true })
    	.click('.btn-primary')
    	.expect(Selector('.alert-success').innerText).eql('Profil édité avec succès')
    	.click('#navbarDropdown')
        .wait(1000)
		.click('#edit')
		.wait(2000)
		.click('#change-psw')
		.typeText('#new_psw', 'user1',{ replace: true })
		.typeText('#new_psw_repeat', 'user1',{ replace: true })
		.typeText('#old_psw', 'user',{ replace: true })
		.click('.btn-primary')
		.expect(Selector('.alert-danger').innerText).eql('Le nouveau mot de passe n\'est pas valide')
		.wait(2000)
		;
		

});