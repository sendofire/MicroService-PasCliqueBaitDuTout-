package fr.univamu.iut.microservicepascliquebaitdutout;

import jakarta.persistence.EntityManager;
import jakarta.persistence.PersistenceContext;
import jakarta.enterprise.context.ApplicationScoped;

import java.util.Date;
import java.util.List;

@ApplicationScoped
public class MenuDAO {

    @PersistenceContext(unitName = "menusPU")
    private EntityManager em;

    public List<Menu> findAll() {
        return em.createQuery("SELECT m FROM Menu m", Menu.class).getResultList();
    }

    public Menu findById(int id) {
        return em.find(Menu.class, id);
    }

    public Menu create(Menu m) {
        em.persist(m);
        return m;
    }

    public Menu update(Menu m) {
        m.setDateMaj(new Date());
        return em.merge(m);
    }

    public void delete(int id) {
        Menu m = findById(id);
        if (m != null) em.remove(m);
    }
}