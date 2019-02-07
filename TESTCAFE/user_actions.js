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

test('user_actions', async t => {
    await t
        .useRole(userLogged)
        .wait(1000)
        .click('#navbarDropdown')
        .wait(1000)
        .click('#add-dish')
        .wait(1000)
        .expect(Selector('.titleProfile').innerText).eql('AJOUTER UN PLAT')
        .typeText('#name', 'Poulet tikka massala')
	    .typeText('#description', 'Un classique de la cuisine indienne')
	    .typeText('#nb_servings', '6')
	    .typeText('#price', '5')
	    .click(Selector('#cat-1'))
		.click(Selector('#cat-1').find('option').withText('poulet'))
		.click('.btn-success')
		.expect(Selector('.alert-danger').innerText).eql('The photo1 field is required.\n')
		.wait(1000)
		.click('#navbarDropdown')
        .wait(1000)
		.click('#add-demand')
		.wait(1000)
		.expect(Selector('.titleProfile').innerText).eql('AJOUTER UNE DEMANDE')
		.typeText('#title', 'Buffet traiteur')
		.typeText('#description', 'Entrée, plat, dessert pour 15 personnes')
		.typeText('#budget', '200')
		.typeText('#phone', '0140045950')
		.typeText('#email', 'tiit@coding-academy.com')
		.click('.btn-success')
		.wait(2000)
		.expect(Selector('.alert-success').innerText).eql('Votre demande a été ajoutée avec succès !')
		.click('#demandes')
		.wait(2000)
		.click('#navbarDropdown')
        .wait(1000)
		.click('#my-page')
		.wait(2000)
		.click('#navbarDropdown')
        .wait(1000)
		.click('#my-orders')
		.wait(2000)
		.click('#navbarDropdown')
        .wait(1000)
		.click('#my-dishes')
		.wait(2000)
		.click('#navbarDropdown')
        .wait(1000)
		.click('#logout')
		.wait(2000);

});